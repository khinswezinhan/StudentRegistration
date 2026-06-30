<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 📊 Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔍 Index Display Routes
Route::get('/teacher/index', [TeacherController::class, 'index'])->middleware(['auth', 'verified'])->name('teacher.index');
Route::get('/student/index', [StudentController::class, 'index'])->middleware(['auth', 'verified'])->name('student');
Route::get('/course/index', [CourseController::class, 'index'])->middleware(['auth', 'verified'])->name('course');
Route::get('/user/index', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('user');

// ==========================================
// 🎓 STUDENT ROUTES
// ==========================================
// 💡 ပြင်ဆင်ချက်: ရိုးရိုး view တန်းမပြဘဲ ဒေတာသယ်ပေးမယ့် Controller က create function ဆီ မောင်းသွင်းလိုက်ပါတယ်
Route::get('/user-create-form', [StudentController::class, 'create']); // URL အဟောင်းအတွက် backup
Route::get('/student/create', [StudentController::class, 'create'])->name('student.create'); // နင်အလိုရှိတဲ့ ကျောင်းသား create URL အသစ်

Route::post('/student-create', [StudentController::class, 'Student'])->name('student.store');
Route::delete('/student/{student}', [StudentController::class, 'destroy'])->name('student.destroy');
Route::get('/edit-content/{id}', [StudentController::class, 'showEditScreen'])->name('student.edit');
Route::put('/update-content/{id}', [StudentController::class, 'update'])->name('student.update');

// ==========================================
// 👨‍🏫 TEACHER ROUTES (ဌာနစနစ် ပြီးပြည့်စုံအောင် ပြင်ဆင်ပြီး)
// ==========================================
Route::get('/teacher-create', [TeacherController::class, 'create'])->name('teacher.create'); 

Route::post('/teacher-store', [TeacherController::class, 'Teacher'])->name('teacher.store');
Route::delete('/teacher/{teacher}', [TeacherController::class, 'destroy'])->name('teacher.destroy');
Route::get('/teacher-edit/{id}', [TeacherController::class, 'showEdit'])->name('teacher.edit');
Route::put('/teacher-update/{id}', [TeacherController::class, 'update'])->name('teacher.update');

// ==========================================
// 📚 COURSE ROUTES
// ==========================================
Route::get('/course', [CourseController::class, 'index'])->middleware(['auth', 'verified'])->name('course.index');
Route::get('/course/create', [CourseController::class, 'create'])->middleware(['auth', 'verified'])->name('course.create');
Route::post('/course', [CourseController::class, 'store'])->middleware(['auth', 'verified'])->name('course.store'); 
Route::get('/course/{id}/edit', [CourseController::class, 'edit'])->middleware(['auth', 'verified'])->name('course.edit');
Route::put('/course/{id}', [CourseController::class, 'update'])->middleware(['auth', 'verified'])->name('course.update');
Route::delete('/course/{course}', [CourseController::class, 'destroy'])->middleware(['auth', 'verified'])->name('course.destroy');
Route::delete('/course-file/{id}', [CourseController::class, 'destroyFile'])->middleware(['auth', 'verified'])->name('course.file.destroy');
Route::delete('/course/{id}/delete-file', [CourseController::class, 'deleteFile'])->name('course.file.delete');
Route::get('/get-courses-by-dept/{department_id}', [TeacherController::class, 'getCourses']);
// ==========================================
// 👥 USER MANAGEMENT ROUTES
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('manage_user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

// 👤 PROFILE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';