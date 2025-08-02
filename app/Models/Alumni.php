<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;
    protected $table = 'alumni'; // Specify the table name if it differs from the model name
    protected $fillable = [
        'nama',
        'leads',
        'leads_custom',
        'provinsi_id',
        'provinsi_nama',
        'kota_id',
        'kota_nama',
        'jenis_bisnis',
        'nama_bisnis',
        'no_wa',
        'kendala',
        'ikut_kelas',
        'kelas_id',
        'sudah_pernah_ikut_kelas_apa_saja',
        'kelas_yang_belum_diikuti_apa_saja'
    ];
    protected $casts = [
        'ikut_kelas' => 'boolean', // Cast ikut_kelas to boolean
        'kelas_id' => 'integer', // Cast kelas_id to integer
    ];
    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas', 'kelas_id');
    }
    
}
