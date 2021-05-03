<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;

class Lecturer extends Model
{
    use HasFactory;
    protected $table = 'lecturer';
    protected $primaryKey = 'ID_lecturer';
    protected $fillable = [
        'ID_user',
        'ID_course',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_user');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'ID_course');
    }
}
