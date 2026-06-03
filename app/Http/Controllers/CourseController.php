<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\Teacher; 
use Symfony\Component\HttpFoundation\RedirectResponse;

class CourseController extends Controller
{
        public function index() 
    {
        $allContents = Course::with('teacher')->get(); 
        $data = ['courses' => $allContents];
        
        return view('course.index', $data); 
    }

    
    public function create()
    {
        $teachers = Teacher::all(); 
        return view('course.create', ['teachers' => $teachers]);
    }

     
    public function store(StoreCourseRequest $request) : RedirectResponse
        {
        $incomingFields = $request->validated();
        
        $incomingFields['file'] = strip_tags($incomingFields['file']);
        $incomingFields['course_name'] = strip_tags($incomingFields['course_name']);
        $incomingFields['teacher_id'] = strip_tags($incomingFields['teacher_id']);

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('file'), $filename);

            $incomingFields['file'] = $filename;
        }

        Course::create($incomingFields);
        
        return redirect()->route('course.index')->with('success', 'Course created successfully');
    }

    
    public function destroy(Course $course) 
    {
        $course->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }

        public function edit($id) 
    {
        $course = Course::find($id);
        $teachers = Teacher::all(); 
        
        return view('course.edit', [ 
            'course' => $course,
            'teachers' => $teachers
        ]);
    }

   
    public function update($id, StoreCourseRequest $request) : RedirectResponse
    {
        $course = Course::find($id);

        $incomingFields = $request->validated();


        $incomingFields['course_name'] = strip_tags($incomingFields['course_name']);
        $incomingFields['teacher_id'] = strip_tags($incomingFields['teacher_id']);

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('file'), $filename);

            $incomingFields['file'] = $filename;
        }

        $course->update($incomingFields);

        return redirect()->route('course.index')->with('success', 'Successfully updated');
    }
}