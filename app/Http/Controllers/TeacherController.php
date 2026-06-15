<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeacherController extends Controller
{
    public function Teacher(StoreTeacherRequest $request) : RedirectResponse {
    $incomingFields = $request->validated ();
    $incomingFields['image'] = strip_tags($incomingFields['image']);
    $incomingFields['name'] = strip_tags($incomingFields['name']);
    $incomingFields['rank'] = strip_tags($incomingFields['rank']);
    $incomingFields['email'] = strip_tags($incomingFields['email']);
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['address'] = strip_tags($incomingFields['address']);

     if ($request->hasFile('image')) {

    $file = $request->file('image');

    $filename = time() . '_' . $file->getClientOriginalName();

    $file->move(public_path('image'), $filename);

    $incomingFields['image'] = $filename;
}



    Teacher::create($incomingFields);
    return redirect('/teacher/index');
     }


    public function index(Request $request) 
{
    $query = Teacher::query();

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('rank')) {
        $query->where('rank', 'like', '%' . $request->rank . '%');
    }

    $allContents = $query->paginate(5)->appends($request->all());
    
    $data = ['teachers' => $allContents];
    
    return view('teacher.index', $data);
}
      

     public function destroy(Teacher $teacher) 
       {
          $teacher->delete();
          return redirect()->back()->with('success', 'Successfully deleted');
       }

       
public function showEdit($id) {
    $teacher = Teacher::find($id);
    return view('/teacher/edit', ['teacher' => $teacher]);
}


public function update($id, StoreTeacherRequest $request) : RedirectResponse 
{
    $teacher = Teacher::findOrFail($id);

    // Request ဖိုင်ကနေ စစ်ဆေးပြီးသား ဒေတာတွေကို ယူမယ်
    $incomingFields = $request->validated();

    // စာသားတွေကို သန့်စင်မယ်
    $incomingFields['name'] = strip_tags($incomingFields['name']);
    $incomingFields['rank'] = strip_tags($incomingFields['rank']);
    $incomingFields['email'] = strip_tags($incomingFields['email']);
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['address'] = strip_tags($incomingFields['address']);

    // 🖼️ ပုံအသစ် တင်မတင် စစ်ဆေးခြင်း အပိုင်း
    if ($request->hasFile('image')) {
        
        // (က) ပုံဟောင်းရှိရင် Storage (`public/image`) ထဲကနေ အရင်သွားဖျက်မယ်
        if ($teacher->image) {
            $oldImagePath = public_path('image/' . $teacher->image);
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
        $incomingFields['image'] = $teacher->image;
    }

    // ဒေတာဘေ့စ်ထဲမှာ အားလုံးကို Update လုပ်မယ်
    $teacher->update($incomingFields);

    return redirect('/teacher/index')->with('success', 'Teacher updated successfully');
}
}
