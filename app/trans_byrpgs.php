<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trans_byrpgs extends Model
{
    protected $table = 'trans_byr_petugas';
    protected $primaryKey = 'id_trans_byrpgs';

    protected $fillable = [
        'id_trans_byrpgs',
        'id_bank',
        'id_pengguna',
        'id_petugas',
        'id_harga_organik',
        'id_harga_anorganik',
        'harga_organik',
        'harga_anorganik',
        'tgl_buang',
        'berat_organik',
        'berat_anorganik',
        'status_klaim'
    ];
}
