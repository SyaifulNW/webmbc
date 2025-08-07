<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas'; // Nama tabel
    protected $fillable = ['nama_kelas', 'deskripsi']; // Kolom yang dapat diisi secara massal

    /**
     * Relasi dengan model data.
     */
    public function data()
    {
        return $this->hasMany('App\Models\data', 'kelas_id');
    }
    public function salesplans()
    {
        return $this->hasMany(SalesPlan::class);
    }
}
