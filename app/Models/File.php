<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;

class File extends Model
{
    use HasFactory;
    protected $table = 'file';
    protected $primaryKey = 'ID_file';
    protected $fillable = [
        'ID_material',
        'file_name',
    ];
    public function material()
    {
        return $this->belongsTo(Material::class, 'ID_material');
    }
}
