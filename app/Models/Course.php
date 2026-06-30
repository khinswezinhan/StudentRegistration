<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // 💡 ဒါလေး အသစ်တိုးလာတယ်

class Course extends Model
{
    protected $table = 'courses';
    
   protected $fillable = ['course_name', 'class_model_id','department_id', 'file'];
    
    protected $casts = ['file' => 'array'];

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_model_id');
    }

     public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }
    public function students() {
         return $this->belongsToMany(Student::class);
    }
}