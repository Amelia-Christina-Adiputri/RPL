<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransByrPetugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_byr_petugas', function (Blueprint $table) {
            $table->bigIncrements('id_trans_byrpgs');
            $table->bigInteger('id_bank');
            $table->bigInteger('id_petugas');
            $table->bigInteger('id_pengguna');
            $table->bigInteger('id_harga');
            $table->dateTime('tgl_buang');
            $table->bigInteger('berat_organik');
            $table->bigInteger('berat_anorganik');
            $table->boolean('status_klaim');
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
        Schema::dropIfExists('trans_byr_petugas');
    }
}
