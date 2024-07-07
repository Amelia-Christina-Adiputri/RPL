<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trans_byrpgn extends Model
{
    protected $table = 'trans_byr_pengguna';
    protected $primaryKey = 'id_trans_byrpgn';

    protected $fillable = [
        'id_trans_byrpgn',
        'id_trans_psp',
        'tgl_bayar',
    ];
}
