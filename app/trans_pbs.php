<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trans_pbs extends Model
{
    protected $table = 'trans_daftar_bank';
    protected $primaryKey = 'id_trans_pbs';

    protected $fillable = [
        'id_trans_pbs',
        'id_pengguna',
        'id_bank',
        'tgl_trans_pbs',
        'status_daftar',
    ];
}
