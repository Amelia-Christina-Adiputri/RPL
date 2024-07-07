<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank_harga extends Model
{
    protected $table = 'bank_harga';
    protected $primaryKey = 'id_harga';

    protected $fillable = [
        'id_harga',
        'jenis_sampah',
        'harga_sampah',
    ];
}
