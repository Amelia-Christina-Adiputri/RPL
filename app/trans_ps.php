<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trans_ps extends Model
{
    protected $table = 'trans_penerimaan_sampah';
    protected $primaryKey = 'id_trans_ps';

    protected $fillable = [
        'id_trans_psp',
        'id_bank',
        'id_petugas',
        'id_pengguna',
        'berat_organik',
        'berat_anorganik',
        'harga_organik',
        'harga_anorganik',
        'status_penerimaan'
    ];
}
