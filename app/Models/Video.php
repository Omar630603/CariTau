<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table = 'video';
    protected $primaryKey = 'ID_video';
    protected $fillable = [
        'ID_material',
        'video_url',
    ];
}
