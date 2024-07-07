<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPengajuanSampahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_pengajuan_sampah', function (Blueprint $table) {
            $table->bigIncrements('id_trans_psp');
            $table->bigInteger('id_pengguna');
            $table->bigInteger('id_petugas');
            $table->dateTime('tgl_trans_psp');
            $table->dateTime('tgl_validasi_psp');
            $table->boolean('status_terima');
            $table->bigInteger('iuran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_pengajuan_sampah');
    }
}
