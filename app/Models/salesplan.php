<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class salesplan extends Model
{
    use HasFactory;
     use SoftDeletes; // Tambahkan ini
    protected $table ='salesplans'; // Specify the table name if it differs from the model name
    protected $fillable = [
        'data_id',
        'fu1_hasil', 'fu1_tindak_lanjut',
        'fu2_hasil', 'fu2_tindak_lanjut',
        'fu3_hasil', 'fu3_tindak_lanjut',
        'fu4_hasil', 'fu4_tindak_lanjut',
        'fu5_hasil', 'fu5_tindak_lanjut',
        'fu6_hasil', 'fu6_tindak_lanjut',
        'fu7_hasil', 'fu7_tindak_lanjut',
        'fu8_hasil', 'fu8_tindak_lanjut',
        'keterangan',
        'status'
    ];
    protected $casts = [    
        'status' => 'string', // Cast status to string
    ];
    

    /**
     * Relasi dengan model data.
     */
    public function data()
    {
         return $this->belongsTo(Data::class, 'data_id');
    }


        

}
