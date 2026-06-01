<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;


class StudentController extends Controller
{

         public function Student(Request $request){
    $incomingFields = $request->validate ([
      'name' => 'required',
      'class' => 'required',
      'email' => 'required',
      'phone' => 'required',
      'address' => 'required',
    ]);

    $incomingFields['name'] = strip_tags($incomingFields['name']);
    $incomingFields['class'] = strip_tags($incomingFields['class']);
    $incomingFields['email'] = strip_tags($incomingFields['email']);
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['address'] = strip_tags($incomingFields['address']);
     

    Student::create($incomingFields);
    return redirect('/student/index');
     }


     public function index() 
       {
          $allContents = Student::all(); 
          $data = ['students' => $allContents];
          return view('/student/index', $data);
       }
     public function destroy(Student $student) 
       {
          $student->delete();
          return redirect()->back()->with('success', 'Successfully deleted');
       }

       
public function showEditScreen($id) {
    $student = Student::find($id);
    return view('/student/edit', ['student' => $student]);
}


public function update($id, Request $request) {
    $student = Student::find($id);

    $incomingFields = $request->validate([
        'name' => 'required',
      'class' => 'required',
      'email' => 'required',
      'phone' => 'required',
      'address' => 'required',
    ]);

    $incomingFields['name'] = strip_tags($incomingFields['name']);
    $incomingFields['class'] = strip_tags($incomingFields['class']);
    $incomingFields['email'] = strip_tags($incomingFields['email']);
    $incomingFields['phone'] = strip_tags($incomingFields['phone']);
    $incomingFields['address'] = strip_tags($incomingFields['address']);

    
    $student->update($incomingFields);

    
    return redirect('/student/index');
}
    
}
