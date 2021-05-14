<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lecturer;
use App\Models\User;
use App\Models\Major;

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
    public function user()
    {
        return $this->belongsToMany(User::class, 'enrollment', 'ID_user', 'ID_course')->withTimestamps()->withPivot('status');;
    }
    public function major()
    {
        return $this->belongsTo(Major::class, 'ID_major');
    }
}
