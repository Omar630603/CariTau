<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $table = 'forum';
    protected $primaryKey = 'ID_forum';
    protected $fillable = [
        'ID_material',
        'title',
        'body',
    ];
    public function material()
    {
        return $this->belongsTo(Material::class, 'ID_material');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_user');
    }
    public function comment()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('ID_parent');
    }
}
