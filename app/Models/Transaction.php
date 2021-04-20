<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $primaryKey = 'ID_transaction';
    protected $fillable = [
        'ID_user',
        'ID_course',
        'ID_bank',
        'proof',
    ];
}
