<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $fillable = ['name'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'class_model_id');
    }
}
