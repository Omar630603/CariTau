<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;
    protected $table = 'major';
    protected $primaryKey = 'ID_major';
    protected $fillable = [
        'major_name',
        'description',
    ];
}
