<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $table = 'enrollment';
    protected $primaryKey = 'ID_enrollment';
    protected $fillable = [
        'ID_user',
        'ID_course',
        'status',
    ];
}
