<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeacherController extends Controller
{
    public function create()
    {
        $departments = Department::all();
        $courses = Course::all(); 

        return view('teacher.create', compact('departments', 'courses'));
    }

    public function getCourses($department_id)
    {
        $department = Department::find($department_id);
        
        if (!$department) {
            return response()->json([]);
        }

        $courses = $department->courses()->get(['id', 'course_name']);
        
        return response()->json($courses);
    }

    public function Teacher(StoreTeacherRequest $request) : RedirectResponse 
    {
        $incomingFields = $request->validated();
        
        $incomingFields['department_id'] = strip_tags($incomingFields['department_id']);
        $incomingFields['image'] = strip_tags($incomingFields['image'] ?? '');
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

        // ၁။ Teacher ကို အရင် ဆောက်မယ်
        $teacher = Teacher::create($incomingFields);

        // 💡 ၂။ ရွေးချယ်လိုက်တဲ့ သင်တန်းတွေကို ကြားခံ table (course_teacher) ထဲ အလိုအလျောက် သွားသိမ်းပေးတဲ့အပိုင်း
        if ($request->has('course_ids')) {
            $teacher->courses()->attach($request->course_ids);
        }

        return redirect('/teacher/index')->with('success', 'Teacher created successfully');
    }

    public function index(Request $request) 
{
    // N+1 Problem မဖြစ်အောင် ကော၊ Index မှာ သင်တန်းနာမည် ပေါ်အောင်ပါ courses ကို တွဲခေါ်ထားသည်
    $query = Teacher::with(['department', 'courses']);

    // Teacher Name ကို Space နှင့် Case Ignore လုပ်၍ LIKE ဖြင့် ရှာဖွေခြင်း
    if ($request->filled('name')) {
        // Request ထဲက လာတဲ့စာသားကို Space အကုန်ဖြုတ်သည်
        $searchTeacherName = str_replace(' ', '', $request->name);

        $query->whereRaw("REPLACE(name, ' ', '') LIKE ?", ['%' . $searchTeacherName . '%']);
    }

    // Rank (ရာထူး) ကို Space နှင့် Case Ignore လုပ်၍ LIKE ဖြင့် ရှာဖွေခြင်း
    if ($request->filled('rank')) {
        // Request ထဲက လာတဲ့စာသားကို Space အကုန်ဖြုတ်သည်
        $searchRank = str_replace(' ', '', $request->rank);

        $query->whereRaw("REPLACE(rank, ' ', '') LIKE ?", ['%' . $searchRank . '%']);
    }

    $allContents = $query->paginate(5)->appends($request->all());
    
    $data = ['teachers' => $allContents];
    
    return view('teacher.index', $data);
}
        
    public function destroy(Teacher $teacher) 
    {
        // Many-to-Many ဖြစ်လို့ ကြားခံ table ထဲက data ကိုပါ အရင်ဖြုတ်ချပေးပါတယ်
        $teacher->courses()->detach();
        
        if ($teacher->image) {
            $imagePath = public_path('image/' . $teacher->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $teacher->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }

   public function showEdit($id) 
{
    // 1. Teacher နဲ့ သူသင်နေတဲ့ courses တွေကို အရင်ဆွဲထုတ်မယ်
    $teacher = Teacher::with('courses')->find($id);
    
    // 2. ဘယ်တန်းမှမရှိရင် 404 ပြပေးဖို့ အကောင်းဆုံးမို့ find အစား findOrFail သုံးတာ ပိုစိတ်ချရပါတယ်
    if (!$teacher) {
        abort(404, 'Teacher not found');
    }

    $departments = Department::all();

    // 💡 ပြင်ဆင်ရမည့်နေရာ: Course::all() အစား Teacher ရဲ့ လက်ရှိ department_id နဲ့ ညီတဲ့ ကောင်တွေကိုပဲ ဆွဲထုတ်မယ်
    $courses = Course::where('department_id', $teacher->department_id)->get(); 
    
    return view('teacher.edit', [
        'teacher' => $teacher,
        'departments' => $departments,
        'courses' => $courses
    ]);
}


    public function update($id, StoreTeacherRequest $request) : RedirectResponse 
    {
        $teacher = Teacher::findOrFail($id);
        $incomingFields = $request->validated();

        $incomingFields['department_id'] = strip_tags($incomingFields['department_id']);
        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['rank'] = strip_tags($incomingFields['rank']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['phone'] = strip_tags($incomingFields['phone']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

        if ($request->hasFile('image')) {
            if ($teacher->image) {
                $oldImagePath = public_path('image/' . $teacher->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $incomingFields['image'] = $filename;
        } else {
            $incomingFields['image'] = $teacher->image;
        }

        // Teacher data ကို Update လုပ်မယ်
        $teacher->update($incomingFields);

        // 💡 ၃။ ကြားခံ table (course_teacher) ထဲက data ကို sync() သုံးပြီး အသစ်/အဟောင်း ညှိပေးလိုက်ပါတယ်
        // Checkbox ဘာမှမရွေးထားရင် array အလွတ် [] ပို့ပေးပြီး အကုန် ဖြုတ်ချပေးမှာပါ
        $teacher->courses()->sync($request->input('course_ids', []));

        return redirect('/teacher/index')->with('success', 'Teacher updated successfully');
    }
}