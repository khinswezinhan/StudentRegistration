<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher; 
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Course List ပြသမည့်နေရာ
     */
    public function index() 
    {
        $allContents = Course::with('teacher')->get(); 
        $data = ['courses' => $allContents];
        
        return view('course.index', $data); // 👈 Dot (.) သုံးပြီး ပြင်ထားပါတယ်
    }

    /**
     * Course Create Form ဖွင့်မည့်နေရာ
     */
    public function create()
    {
        $teachers = Teacher::all(); 
        // ⚠️ အရင်က view('course.index') လို့ မှားခေါ်ထားမိလို့ view('course.create') လို့ ပြင်လိုက်ပါတယ်
        return view('course.create', ['teachers' => $teachers]);
    }

    /**
     * Form ကလာတဲ့ ဒေတာကို DB ထဲ သိမ်းမည့်နေရာ
     */
    public function store(Request $request) // 👈 စံနှုန်းအတိုင်း store လို့ ပြောင်းပါတယ်
    {
        $incomingFields = $request->validate([
            'course_name' => 'required',
            'teacher_id' => 'required|exists:teachers,id', 
        ]);

        $incomingFields['course_name'] = strip_tags($incomingFields['course_name']);
        $incomingFields['teacher_id'] = strip_tags($incomingFields['teacher_id']);

        Course::create($incomingFields);
        
        return redirect()->route('course.index')->with('success', 'Course created successfully');
    }

    /**
     * Course ဖျက်မည့်နေရာ
     */
    public function destroy(Course $course) 
    {
        $course->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }

    /**
     * Course Edit Form ဖွင့်မည့်နေရာ
     */
    public function edit($id) // 👈 စံနှုန်းအတိုင်း edit လို့ ပြောင်းပါတယ်
    {
        $course = Course::find($id);
        $teachers = Teacher::all(); 
        
        return view('course.edit', [ // 👈 စာလုံးအသေး 'course.edit' ဟု ပြင်ထားပါတယ်
            'course' => $course,
            'teachers' => $teachers
        ]);
    }

    /**
     * ပြင်ဆင်လိုက်တဲ့ ဒေတာကို DB ထဲ သွား Update လုပ်မည့်နေရာ
     */
    public function update($id, Request $request) 
    {
        $course = Course::find($id);

        $incomingFields = $request->validate([
            'course_name' => 'required',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $incomingFields['course_name'] = strip_tags($incomingFields['course_name']);
        $incomingFields['teacher_id'] = strip_tags($incomingFields['teacher_id']);

        $course->update($incomingFields);

        return redirect()->route('course.index')->with('success', 'Successfully updated');
    }
}