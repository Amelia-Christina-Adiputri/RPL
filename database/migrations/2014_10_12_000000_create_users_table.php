<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user');
            $table->string('role');
            $table->string('nama')->nullable();;
            $table->string('email')->unique();
            $table->string('password');
            $table->string('alamat')->nullable();;
            $table->bigInteger('latitude')->nullable();;
            $table->bigInteger('longitude')->nullable();;
            $table->char('telp', 13);
            $table->bigInteger('kapasitas_petugas')->nullable();
            $table->bigInteger('tarif_petugas')->nullable();
            $table->bigInteger('kapasitas_organik_bank')->nullable();
            $table->bigInteger('kapasitas_anorganik_bank')->nullable();
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
        Schema::dropIfExists('users');
    }
}
