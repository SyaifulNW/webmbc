<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenisbisnis extends Model
{
    use HasFactory;
    protected $table = 'jenisbisnis';
    protected $fillable = [
        'nama', // Nama jenis bisnis
    ];
    public function data()
    {
        return $this->hasMany('App\Models\data', 'jenis_bisnis');
    }
}
