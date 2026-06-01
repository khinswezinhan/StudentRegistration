<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function Teacher(Request $request){
    $incomingFields = $request->validate ([
      'name' => 'required',
      'rank' => 'required',
      'email' => 'required|email|unique:teachers',
      'phone' => 'required',
      'address' => 'required',
    ]);

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


public function update($id, Request $request) {
    $teacher = Teacher::find($id);

    $incomingFields = $request->validate([
      'name' => 'required',
      'rank' => 'required',
      'email' => 'required|email|unique:students,email',
      'phone' => 'required',
      'address' => 'required',
    ]);

    $incomingFields['name'] = strip_tags($incomingFields['name']);
    $incomingFields['rank'] = strip_tags($incomingFields['rank']);
    $incomingFields['email'] = strip_tags($incomingFields['email']);
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['address'] = strip_tags($incomingFields['address']);

    
    $teacher->update($incomingFields);

    
    return redirect('/teacher/index');
}
}
