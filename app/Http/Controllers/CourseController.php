<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\Department;
use App\Models\ClassModel; // 💡 ➕ ClassModel ကို အသုံးပြုရန် Import ထည့်ပေးထားပါတယ်
use App\Models\FileModel; 
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class CourseController extends Controller
{
    public function index(Request $request) 
{
    // Course ဇယားမှာ ဘယ် Class နဲ့ဆိုင်လဲဆိုတာ မြင်ရအောင် classModel Relation ကို eager load ခေါ်ထားသည်
    $query = Course::with('classModel');

    // Course Name ကို Space နှင့် Case Ignore လုပ်၍ LIKE ဖြင့် ရှာဖွေခြင်း
    if ($request->filled('course_name')) {
        // Request ထဲက လာတဲ့စာသားကို Space အကုန်ဖြုတ်သည်
        $searchCourseName = str_replace(' ', '', $request->course_name);

        $query->whereRaw("REPLACE(course_name, ' ', '') LIKE ?", ['%' . $searchCourseName . '%']);
    }

    $allContents = $query->paginate(5)->appends($request->all());
    
    $data = ['courses' => $allContents];
    
    return view('course.index', $data); 
}

    public function create()
    {
        $classes = ClassModel::all();
        $departments = Department::all(); 

 
        return view('course.create', compact('classes', 'departments'));
    }

   public function store(StoreCourseRequest $request) : RedirectResponse
{
    // StoreCourseRequest ထဲကနေ သန့်စင်ပြီးသား ဒေတာတွေကို ယူမယ်
    $incomingFields = $request->validated();
    
    $incomingFields['course_name'] = strip_tags($incomingFields['course_name']);
    $incomingFields['class_model_id'] = strip_tags($incomingFields['class_model_id']);
    $incomingFields['department_id'] = strip_tags($incomingFields['department_id']);

    $fileNames = [];
    
    // 🎯 ရွေးလိုက်တဲ့ ဖိုင်တွေ ရှိမရှိ စစ်ပြီး Loop ပတ်မယ်
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $pureOriginalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            
            // ဖိုင်နာမည် တူတာတွေ ရှိရင် မထပ်အောင် time() ခံပေးထားတာ ရှယ်ပဲဗျာ
            $filename = time() . '_' . $pureOriginalName;
            $file->move(public_path('file'), $filename);
            $filePath = 'file/' . $filename;

            // FileModel ထဲကို ဒေတာသွင်းခြင်း
            FileModel::create([
                'file_name' => $pureOriginalName, 
                'directory' => 'file',
                'extension' => $extension,
                'file_path' => $filePath, 
            ]);

            // Course table ထဲမှာ JSON string အနေနဲ့ သိမ်းဖို့ နာမည်ကို သိမ်းထားမယ်
            $fileNames[] = $filename; 
        }
    }

    // $fileNames array ကြီးကို $incomingFields ထဲ ထည့်လိုက်မယ် (Model ထဲမှာ ကာစ်လုပ်ထားပြီးသားမို့ အိုကေတယ်)
    $incomingFields['file'] = $fileNames;

    // Course ကို ဒေတာဘေ့စ်ထဲ သိမ်းလိုက်ပြီဗျာ
    Course::create($incomingFields);
    
    return redirect()->route('course.index')->with('success', 'Course created successfully');
}

    public function destroy(Course $course) 
    {
        if ($course->file && is_array($course->file)) {
            foreach ($course->file as $fileName) {
                $filePath = public_path('file/' . $fileName);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

                FileModel::where('file_path', 'file/' . $fileName)->delete();
            }
        }

        $course->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }

   public function edit($id)
{
    $course = Course::findOrFail($id);
    $classes = ClassModel::all();
    $departments = Department::all();

    return view('course.edit', compact('course', 'classes', 'departments'));
}

    public function update($id, StoreCourseRequest $request) : RedirectResponse
    {
        $course = Course::find($id);
        $incomingFields = $request->validated();

        $incomingFields['course_name'] = strip_tags($incomingFields['course_name']);
        
        // 💡 ➕ Update လုပ်တဲ့နေရာမှာလည်း ရွေးချယ်လိုက်တဲ့ class_model_id အသစ်ကို ထည့်ပေးပါတယ်
        $incomingFields['class_model_id'] = strip_tags($incomingFields['class_model_id']);
        $incomingFields['department_id'] = strip_tags($incomingFields['department_id']);

        $currentFiles = is_array($course->file) ? $course->file : [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $pureOriginalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
                $filename = time() . '_' . $pureOriginalName;
                $file->move(public_path('file'), $filename);
                $filePath = 'file/' . $filename;

                FileModel::create([
                    'file_name' => $pureOriginalName, 
                    'directory' => 'file',
                    'extension' => $extension,
                    'file_path' => $filePath,
                ]);

                $currentFiles[] = $filename; 
            }
        }

        $incomingFields['file'] = $currentFiles;

        $course->update($incomingFields);

        return redirect()->route('course.index')->with('success', 'Successfully updated');
    }

    public function deleteFile(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $fileNameToDelete = $request->input('file_name'); 

        $currentFiles = is_array($course->file) ? $course->file : [];

        $filePath = public_path('file/' . $fileNameToDelete);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        FileModel::where('file_path', 'file/' . $fileNameToDelete)->delete();

        $updatedFiles = array_values(array_filter($currentFiles, function($name) use ($fileNameToDelete) {
            return $name !== $fileNameToDelete;
        }));

        $course->update(['file' => $updatedFiles]);

        return response()->json(['success' => true, 'message' => 'File deleted successfully']);
    }
}