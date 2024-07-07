<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank_proses extends Model
{
    protected $table = 'bank_proses';
    protected $primaryKey = 'id_proses';

    protected $fillable = [
        'id_proses',
        'id_bank',
        'jenis_proses',
        'kapasitas_organik',
        'kapasitas_anorganik',
        'berat_organik',
        'berat_anorganik',
    ];
}
