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
        // 🎯 ၁။ Validation အောင်ပြီးသား ဒေတာကို ယူမယ် (ဒီထဲမှာ class_model_id ပါပြီးသားဖြစ်လို့ အိုကေတယ်)
        $incomingFields = $request->validated();
        
        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['phone'] = strip_tags($incomingFields['phone']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

        // 💡 ရှင်းလင်းချက်: စောစောက class_model_id ကို ဖမ်းပြီး class နာမည်လိုက်ရှာတဲ့ ကုဒ်ဟောင်းတွေကို ဖြုတ်ပစ်လိုက်ပြီဟေ့!
        // ဘာလို့လဲဆိုတော့ Database ထဲမှာ class_model_id အတိုင်း တန်းသိမ်းမှာမို့လို့ပါဗျာ။

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $incomingFields['image'] = $filename; 
        }

        // ၂။ ကျောင်းသားကို ဒေတာဘေ့စ်ထဲ သိမ်းမယ် (students table ထဲမှာ id အမှန်အတိုင်း တန်းဝင်သွားပြီ)
        $student = Student::create($incomingFields);

        // ၃။ Pivot Table (course_student) ထဲမှာ ဆက်စပ် Course တွေ တခါတည်း တွဲသိမ်းမယ်
        $classId = $request->class_model_id;
        if ($classId && $student) {
            // အတန်း ID နဲ့ ကိုက်ညီတဲ့ course_id တွေကို ဆွဲထုတ်တယ်
            $courseIds = Course::where('class_model_id', $classId)->pluck('id')->toArray();

            // course_student ထဲမှာ student_id နဲ့ course_id ကို သွားတွဲသိမ်းလိုက်ပြီဟေ့!
            $student->courses()->sync($courseIds);
        }
        
        return redirect()->route('student')->with('success', 'Student created successfully!');
    }

    /**
     * Student Index / List with Search Filter
     */
  public function index(Request $request) 
{
    $query = Student::with(['classModel.courses']);

    // Student Name ကို Space နှင့် Case Ignore လုပ်၍ LIKE ဖြင့် ရှာဖွေခြင်း
    if ($request->filled('name')) {
        // Request ထဲက လာတဲ့စာသားကို Space အကုန်ဖြုတ်သည်
        $searchStudentName = str_replace(' ', '', $request->name);

        $query->whereRaw("REPLACE(name, ' ', '') LIKE ?", ['%' . $searchStudentName . '%']);
    }

    // Class Model ID ရှာဖွေခြင်း (ID က ကွက်တိစစ်ရမှာမို့လို့ Space ဖြုတ်စရာမလိုပါဘူး)
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
        $incomingFields = $request->validated();

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['phone'] = strip_tags($incomingFields['phone']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

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

        // 🎯 Optional Bonus: Update လုပ်တဲ့အချိန်မှာလည်း ရွေးလိုက်တဲ့ အတန်းအသစ်ပေါ်မူတည်ပြီး Pivot table ထဲက Course တွေကိုပါ လိုက်ပြောင်းပေးချင်ရင် ဒီကုဒ်လေး ထည့်ထားလို့ရတယ်ဗျာ
        $classId = $request->class_model_id;
        if ($classId) {
            $courseIds = Course::where('class_model_id', $classId)->pluck('id')->toArray();
            $student->courses()->sync($courseIds);
        }

        return redirect('/student/index')->with('success', 'Student updated successfully');
    }
}