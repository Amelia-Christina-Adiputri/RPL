<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankProsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_proses', function (Blueprint $table) {
            $table->bigIncrements('id_proses');
            $table->bigInteger('id_bank');
            $table->string('jenis_proses');
            $table->bigInteger('kapasitas_organik');
            $table->bigInteger('kapasitas_anorganik');
            $table->bigInteger('berat_organik');
            $table->bigInteger('berat_anorganik');
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
        Schema::dropIfExists('bank_proses');
    }
}

