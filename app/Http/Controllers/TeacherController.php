<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;

class TeacherController extends Controller
{
    public function Teacher(StoreTeacherRequest $request) : RedirectResponse {
    $incomingFields = $request->validated ();

    $incomingFields['name'] = strip_tags($incomingFields['name']);
    $incomingFields['rank'] = strip_tags($incomingFields['rank']);
    $incomingFields['email'] = strip_tags($incomingFields['email']);
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['address'] = strip_tags($incomingFields['address']);
     

    Teacher::create($incomingFields);
    return redirect('/teacher/index');
     }


     public function index() 
       {
          $allContents = Teacher::all(); 
          $data = ['teachers' => $allContents];
          return view('/teacher/index', $data);
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


public function update($id, StoreTeacherRequest $request) : RedirectResponse{
    $teacher = Teacher::find($id);

    $incomingFields = $request->validated();

    $incomingFields['name'] = strip_tags($incomingFields['name']);
    $incomingFields['rank'] = strip_tags($incomingFields['rank']);
    $incomingFields['email'] = strip_tags($incomingFields['email']);
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['address'] = strip_tags($incomingFields['address']);

    
    $teacher->update($incomingFields);

    
    return redirect('/teacher/index');
}
}
