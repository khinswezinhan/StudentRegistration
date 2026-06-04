<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\Teacher; 
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class CourseController extends Controller
{
    public function index(Request $request) 
    {
        $query = Course::with('teacher');

        if ($request->filled('course_name')) {
            $query->where('course_name', 'like', '%' . $request->course_name . '%');
        }

        $allContents = $query->paginate(5)->appends($request->all());
        
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
        
        $incomingFields['course_name'] = strip_tags($incomingFields['course_name']);
        $incomingFields['teacher_id'] = strip_tags($incomingFields['teacher_id']);

        $fileNames = [];
        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('file'), $filename);
                $fileNames[] = $filename; 
            }
        }

        $incomingFields['file'] = $fileNames;

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
            }
        }

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

        $currentFiles = is_array($course->file) ? $course->file : [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('file'), $filename);
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

        $updatedFiles = array_values(array_filter($currentFiles, function($name) use ($fileNameToDelete) {
            return $name !== $fileNameToDelete;
        }));

        $course->update(['file' => $updatedFiles]);

        return response()->json(['success' => true, 'message' => 'File deleted successfully']);
    }
}