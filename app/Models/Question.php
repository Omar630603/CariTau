<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'question';
    protected $primaryKey = 'ID_question';
    protected $fillable = [
        'ID_quiz',
        'question',
        'option_one',
        'option_two',
        'option_three',
        'option_four',
        'correctAnswer',
    ];
}
