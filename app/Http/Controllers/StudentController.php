<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // 💡 ပုံဟောင်းတွေ ဖျက်ဖို့အတွက် မရှိမဖြစ်လိုအပ်ပါတယ်

class StudentController extends Controller
{
    public function Student(StoreStudentRequest $request) : RedirectResponse 
    {
        $incomingFields = $request->validated();
        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['class'] = strip_tags($incomingFields['class']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['phone'] = strip_tags($incomingFields['phone']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $incomingFields['image'] = $filename;
        }

        Student::create($incomingFields);
        return redirect('/student/index');
    }

    public function index(Request $request) 
    {
        $query = Student::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('class')) {
            $query->where('class', 'like', '%' . $request->class . '%');
        }

        $allContents = $query->paginate(5)->appends($request->all());
        $data = ['students' => $allContents];

        return view('student.index', $data);
    }

    public function destroy(Student $student) 
    {
        // 💡 ကျောင်းသားကို ဒေတာဘေ့စ်ထဲကမဖျက်ခင် public/image ထဲက ပုံပါတစ်ခါတည်း ဖျက်ချလိုက်တာပါ
        if ($student->image) {
            $imagePath = public_path('image/' . $student->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $student->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }

    public function showEditScreen($id) 
    {
        $student = Student::findOrFail($id);
        return view('student.edit', ['student' => $student]); // စာလုံးပေါင်းသတ်ပုံ သန့်ရှင်းအောင် ပြင်ထားပါတယ်
    }

    public function update($id, StoreStudentRequest $request) : RedirectResponse 
    {
        $student = Student::findOrFail($id);
        $incomingFields = $request->validated();

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['class'] = strip_tags($incomingFields['class']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['phone'] = strip_tags($incomingFields['phone']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

        // 🖼️ ပုံအသစ် တက်လာသလား စစ်ဆေးခြင်း အပိုင်း
        if ($request->hasFile('image')) {
            
            // (က) ပုံဟောင်းရှိရင် Storage ထဲကနေ အရင်သွားဖျက်မယ်
            if ($student->image) {
                $oldImagePath = public_path('image/' . $student->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // (ခ) ပုံအသစ်ကို နာမည်ပြောင်းပြီး သိမ်းမယ်
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $incomingFields['image'] = $filename;
        } else {
            // (ဂ) ပုံအသစ် ထပ်မရွေးထားရင် မူလပုံဟောင်း နာမည်ကိုပဲ ဆက်သုံးမယ်
            $incomingFields['image'] = $student->image;
        }

        $student->update($incomingFields);

        return redirect('/student/index')->with('success', 'Student updated successfully');
    }
}