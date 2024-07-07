<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransByrPenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_byr_pengguna', function (Blueprint $table) {
            $table->bigIncrements('id_trans_byrgn');
            $table->bigInteger('id_trans_psp');
            $table->bigInteger('id_petugas');
            $table->bigInteger('id_pengguna');
            $table->dateTime('tgl_bayar');
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
        Schema::dropIfExists('trans_byr_pengguna');
    }
}
