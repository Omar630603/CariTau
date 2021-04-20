<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $table = 'score';
    protected $primaryKey = 'ID_score';
    protected $fillable = [
        'ID_question',
        'ID_user',
        'userAnswer',
        'score',
    ];
}
