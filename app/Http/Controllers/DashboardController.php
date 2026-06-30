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

        // 💡 Courses ကို Departments table နဲ့ Join ပြီး Department အလိုက် Course Count ကို Group By လုပ်ပြီး ဆွဲထုတ်ခြင်း
        $deptCourseCounts = Course::join('departments', 'courses.department_id', '=', 'departments.id')
            ->selectRaw('departments.department_name, count(courses.id) as total')
            ->groupBy('departments.department_name')
            ->get();

        // Chart.js ဘက်က ဖတ်လို့ရမယ့် Array ပုံစံမျိုးဖြစ်အောင် pluck() သုံးပြီး ပြောင်းလဲခြင်း
        $deptLabels = $deptCourseCounts->pluck('department_name')->toArray(); // ['IT', 'Civil', 'EC', ...]
        $deptData = $deptCourseCounts->pluck('total')->toArray();      // [8, 5, 3, ...]

        // 💡 Blade ဘက်ကို ဒေတာတွေအကုန်လုံး ရောက်သွားအောင် compact ထဲမှာ အကုန်ထည့်ပေးထားပါတယ်
        return view('dashboard', compact('users', 'students', 'teachers', 'courses', 'deptLabels', 'deptData'));
    }
}