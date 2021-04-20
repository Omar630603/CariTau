<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;
    protected $table = 'lecturer';
    protected $primaryKey = 'ID_lecturer';
    protected $fillable = [
        'ID_user',
        'ID_course',
    ];
}
