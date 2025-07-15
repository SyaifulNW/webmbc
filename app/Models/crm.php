<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crm extends Model
{
    use HasFactory;
    protected $table = 'crms';
    protected $fillable = [
        'nama',
        'leads',
        'kota',
        'nama_bisnis',
        'no_wa',
        'total_omset',
        'kendala',
        'fu1',
        'fu2',
        'fu3',
        'status',
    ];
}
