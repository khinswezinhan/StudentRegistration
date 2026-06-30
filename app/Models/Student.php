<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        
        'class_model_id', 
        'email', 
        'phone', 
        'address', 
        'image'
    ];

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_model_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student');
    }
}