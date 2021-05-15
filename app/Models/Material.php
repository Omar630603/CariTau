<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
