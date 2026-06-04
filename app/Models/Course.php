<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = ['course_name', 'teacher_id', 'file'];


    protected $casts = [
        'file' => 'array',
    ];

    
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}