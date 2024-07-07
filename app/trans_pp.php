<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trans_pp extends Model
{
    protected $table = 'trans_pengajuan_penerimaan';
    protected $primaryKey = 'id_trans_pp';

    protected $fillable = [
        'id_trans_pp',
        'id_petugas',
        'id_bank',
        'id_pengguna',
        'tgl_pengajuan'
    ];
}
