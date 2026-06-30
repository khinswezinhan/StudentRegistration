<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use App\Models\ClassModel; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use App\Models\Course; 

class StudentController extends Controller
{
    /**
     * Show Student Create Form
     */
    public function create()
    {
        $classes = ClassModel::all(); 
        return view('student.create', compact('classes'));
    }

    /**
     * Store New Student
     */
    public function Student(StoreStudentRequest $request) : RedirectResponse 
    {
        $incomingFields = $request->validated();
        
        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['phone'] = strip_tags($incomingFields['phone']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $incomingFields['image'] = $filename; 
        }

        // 💡 ပြီးပြည့်စုံအောင် ဖြည့်စွက်ချက်: Create လုပ်ချိန်တွင် Form မလိုဘဲ Auto Active ပေးလိုက်ခြင်း
        $incomingFields['status'] = 'active';

        $student = Student::create($incomingFields);

        // Pivot Table (course_student) ထဲမှာ ဆက်စပ် Course တွေ တွဲသိမ်းခြင်း
        $classId = $request->class_model_id;
        if ($classId && $student) {
            $courseIds = Course::where('class_model_id', $classId)->pluck('id')->toArray();
            $student->courses()->sync($courseIds);
        }
        
        return redirect()->route('student')->with('success', 'Student created successfully with Active status!');
    }

    /**
     * Student Index / List with Search Filter
     */
    public function index(Request $request) 
    {
        $query = Student::with(['classModel.courses']);

        // Student Name ကို Space နှင့် Case Ignore လုပ်၍ LIKE ဖြင့် ရှာဖွေခြင်း
        if ($request->filled('name')) {
            $searchStudentName = str_replace(' ', '', $request->name);
            $query->whereRaw("REPLACE(name, ' ', '') LIKE ?", ['%' . $searchStudentName . '%']);
        }

        // Class Model ID ရှာဖွေခြင်း
        if ($request->filled('class_model_id')) {
            $query->where('class_model_id', 'like', '%' . $request->class_model_id . '%');
        }

        $allContents = $query->paginate(5)->appends($request->all());
        $classes = ClassModel::all(); 

        return view('student.index', [
            'students' => $allContents,
            'classes' => $classes
        ]);
    }

    /**
     * Delete Student
     */
    public function destroy(Student $student) 
    {
        // 💡 ပြီးပြည့်စုံအောင် ဖြည့်စွက်ချက်: Inactive ဒေတာဖြစ်နေလျှင် ဖျက်ခွင့်မပြုဘဲ ပိတ်ချခြင်း
        if ($student->status === 'inactive') {
            return redirect()->back()->with('error', 'ဤကျောင်းသားသည် Inactive ဖြစ်နေသဖြင့် ဖျက်ဆီးခွင့်မရှိပါ!');
        }

        if ($student->image) {
            $imagePath = public_path('image/' . $student->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $student->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }

    /**
     * Show Edit Screen
     */
    public function showEditScreen($id) 
    {
        $student = Student::findOrFail($id);

        // 💡 ပြီးပြည့်စုံအောင် ဖြည့်စွက်ချက်: Inactive ဖြစ်နေလျှင် Edit Page ဝင်ခွင့် လုံးဝမပြုပါ
        if ($student->status === 'inactive') {
            return redirect('/student/index')->with('error', 'ဤကျောင်းသားသည် Inactive ဖြစ်နေသဖြင့် ပြင်ဆင်ခွင့်မရှိတော့ပါ!');
        }

        $classes = ClassModel::all(); 
        $courses = Course::all();

        return view('student.edit', compact('student', 'classes','courses')); 
    }

    /**
     * Update Student Data
     */
    public function update($id, StoreStudentRequest $request) : RedirectResponse 
    {
        $student = Student::findOrFail($id);

        // 💡 ပြီးပြည့်စုံအောင် ဖြည့်စွက်ချက်: အရင်ကတည်းက Inactive ဖြစ်နေခဲ့ရင် အတင်းလှမ်း Update လုပ်တာကိုပါ ထပ်မံကာကွယ်ခြင်း
        if ($student->status === 'inactive') {
            return redirect('/student/index')->with('error', 'ဤကျောင်းသားသည် Inactive ဖြစ်နေသဖြင့် ပြင်ဆင်ခွင့်မရှိတော့ပါ!');
        }

        // StoreStudentRequest က လာတဲ့ ဒေတာကို စစ်ဆေးခြင်း
        $incomingFields = $request->validated();

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['phone'] = strip_tags($incomingFields['phone']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

        // 💡 Update အချိန်မှာ Edit Form ရဲ့ Request ကလာတဲ့ Status (active/inactive) ကိုပါ လက်ခံသိမ်းဆည်းမည်
        // (တကယ်လို့ $request->validated() ထဲမှာ status အတွက် သတ်မှတ်မထားမိရင် Request ကနေ တိုက်ရိုက်ဆွဲယူပါတယ်)
        $incomingFields['status'] = $request->input('status', $student->status);

        if ($request->hasFile('image')) {
            if ($student->image) {
                $oldImagePath = public_path('image/' . $student->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $incomingFields['image'] = $filename;
        } else {
            $incomingFields['image'] = $student->image;
        }

        $student->update($incomingFields);

        // Update ဖြစ်သွားတဲ့ အတန်းပေါ်မူတည်ပြီး Pivot table ထဲက Course တွေကို လိုက်ပြောင်းပေးခြင်း
        $classId = $request->class_model_id;
        if ($classId) {
            $courseIds = Course::where('class_model_id', $classId)->pluck('id')->toArray();
            $student->courses()->sync($courseIds);
        }

        return redirect('/student/index')->with('success', 'Student updated successfully');
    }
}