<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPenerimaanSampahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_penerimaan_sampah', function (Blueprint $table) {
            $table->bigIncrements('id_trans_ps');
            $table->bigInteger('id_bank');
            $table->bigInteger('id_petugas');
            $table->bigInteger('id_pengguna');
            $table->bigInteger('berat_organik');
            $table->bigInteger('berat_anorganik');
            $table->bigInteger('harga_organik');
            $table->bigInteger('harga_anorganik');
            $table->boolean('status_penerimaan');
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
        Schema::dropIfExists('trans_penerimaan_sampah');
    }
}
