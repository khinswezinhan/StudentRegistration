<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = ['name', 'rank', 'department_id', 'course_id', 'email', 'phone', 'address', 'image'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

   public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    }

