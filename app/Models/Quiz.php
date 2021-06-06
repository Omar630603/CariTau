<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use App\Models\Question;


class Quiz extends Model
{
    use HasFactory;
    protected $table = 'quiz';
    protected $primaryKey = 'ID_quiz';
    protected $fillable = [
        'ID_material',
        'description',
        'status',
    ];
    public function material()
    {
        return $this->belongsTo(Material::class, 'ID_material');
    }
    public function question()
    {
        return $this->hasMany(Question::class, 'ID_quiz');
    }
}
