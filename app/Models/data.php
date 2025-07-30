<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    use HasFactory;
    protected $table = 'data'; // Specify the table name if it doesn't follow Laravel's naming convention
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
        'situasi_bisnis',
        'kendala',
        'ikut_kelas',
        'kelas_id',
    ];
    public function kelas()
    {
        return $this->belongsTo('App\Models\kelas', 'kelas_id');
    }
    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'provinsi_id');
    }
    public function kota()
    {
        return $this->belongsTo('App\Models\Kota', 'kota_id');
    
}
    public function getLeadsAttribute($value)
    {
        return ucfirst($value);
    }
    public function jenisBisnis()
    {
        return $this->belongsTo('App\Models\jenisbisnis', 'jenis_bisnis');
    }
}

