<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $primaryKey = 'ID_admin';
    protected $fillable = [
        'ID_user',
        'privateKey',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_user');
    }
}
