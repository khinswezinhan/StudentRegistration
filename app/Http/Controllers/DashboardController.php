<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;



class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $students = Student::all();
        $teachers = Teacher::all();
        $courses = Course::all();

        return view('dashboard', compact('users', 'students', 'teachers', 'courses'));
    }
}
