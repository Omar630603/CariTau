<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\File;
use App\Models\Video;
use App\Models\Quiz;

class Material extends Model
{
    use HasFactory;
    protected $table = 'material';
    protected $primaryKey = 'ID_material';
    protected $fillable = [
        'ID_course',
        'material_name',
        'description',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class, 'ID_course');
    }
    public function file()
    {
        return $this->hasMany(File::class, 'ID_material');
    }
    public function video()
    {
        return $this->hasMany(Video::class, 'ID_material');
    }
    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'ID_material');
    }
    public function forum()
    {
        return $this->hasMany(Forum::class, 'ID_material');
    }
}
