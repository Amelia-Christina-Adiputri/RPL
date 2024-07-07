<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trans_psp extends Model
{
    protected $table = 'trans_pengajuan_sampah';
    protected $primaryKey = 'id_trans_psp';

    protected $fillable = [
        'id_trans_pss',
        'id_pengguna',
        'id_petugas',
        'tgl_trans_psp',
        'tgl_validasi_psp',
        'tgl_berlaku',
        'status_terima',
        'iuran',
    ];
}
