<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransDaftarBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_daftar_bank', function (Blueprint $table) {
            $table->bigIncrements('id_trans_pbs');
            $table->bigInteger('id_pengguna');
            $table->bigInteger('id_bank');
            $table->dateTime('tgl_trans_pbs');
            $table->boolean('status_daftar');
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
        Schema::dropIfExists('trans_daftar_bank');
    }
}
