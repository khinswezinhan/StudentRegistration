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

        // 💡 Create ချိန်တွင် Auto Active ပေးခြင်း
        $incomingFields['status'] = 'active';

        $teacher = Teacher::create($incomingFields);

        if ($request->has('course_ids')) {
            $teacher->courses()->attach($request->course_ids);
        }

        return redirect('/teacher/index')->with('success', 'Teacher created successfully');
    }

    public function index(Request $request) 
    {
        $query = Teacher::with(['department', 'courses']);

        if ($request->filled('name')) {
            $searchTeacherName = str_replace(' ', '', $request->name);
            $query->whereRaw("REPLACE(name, ' ', '') LIKE ?", ['%' . $searchTeacherName . '%']);
        }

        if ($request->filled('rank')) {
            $searchRank = str_replace(' ', '', $request->rank);
            $query->whereRaw("REPLACE(rank, ' ', '') LIKE ?", ['%' . $searchRank . '%']);
        }

        $allContents = $query->paginate(5)->appends($request->all());
        
        return view('teacher.index', ['teachers' => $allContents]);
    }
        
    public function destroy(Teacher $teacher) 
    {
        // 💡 Inactive ဖြစ်နေလျှင် Back-end ကနေ ဖျက်ခွင့် ထပ်မံပိတ်ပင်ခြင်း
        if ($teacher->status === 'inactive') {
            return redirect()->back()->with('error', 'ဤဆရာသည် Inactive ဖြစ်နေသဖြင့် ဖျက်ဆီးခွင့်မရှိပါ!');
        }

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
        $teacher = Teacher::with('courses')->find($id);
        
        if (!$teacher) {
            abort(404, 'Teacher not found');
        }

        // 💡 Inactive ဖြစ်နေလျှင် Edit URL ကို တိုက်ရိုက်ရိုက်ရိုက်ဝင်လာလည်း ပိတ်ချမည်
        // if ($teacher->status === 'inactive') {
        //     return redirect('/teacher/index')->with('error', 'ဤဆရာသည် Inactive ဖြစ်နေသဖြင့် ပြင်ဆင်ခွင့်မရှိပါ!');
        // }

        $departments = Department::all();
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

        // 💡 မတော်တဆ Inactive သမားကို ခိုးပြီး Update လာလုပ်ရင် ပိတ်ရန်
        // if ($teacher->status === 'inactive') {
        //     return redirect('/teacher/index')->with('error', 'ဤဆရာသည် Inactive ဖြစ်နေသဖြင့် ပြင်ဆင်ခွင့်မရှိပါ!');
        // }

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

        // 💡 Edit Form မှ ရွေးချယ်ပေးလိုက်သော Status အသစ်ကို လက်ခံရယူခြင်း
        $incomingFields['status'] = $request->input('status', $teacher->status);

        $teacher->update($incomingFields);
        $teacher->courses()->sync($request->input('course_ids', []));

        return redirect('/teacher/index')->with('success', 'Teacher updated successfully');
    }
}