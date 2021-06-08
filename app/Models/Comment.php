<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $primaryKey = 'ID_comment';
    protected $fillable = [
        'ID_user',
        'ID_parent',
        'body',
        'commentable_id',
        'commentable_type',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_user');
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'ID_parent');
    }
}
