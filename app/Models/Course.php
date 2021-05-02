<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lecturer;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $primaryKey = 'ID_course';
    protected $fillable = [
        'ID_major',
        'course_name',
        'description',
        'price',
    ];
    public function lecturer()
    {
        return $this->hasOne(Lecturer::class, 'ID_user');
    }
}
