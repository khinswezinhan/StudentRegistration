<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    protected $table = 'files'; 

    protected $fillable = [
        'file_name',
        'directory',
        'extension',
        'file_path'
    ];
}
