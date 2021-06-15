<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    use HasFactory;
    protected $table = 'quiz_user';
    protected $primaryKey = 'ID_quiz_user';
    protected $fillable = [
        'ID_user',
        'ID_quiz',
        'score',
    ];
}
