<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensi2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi2s', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('jam_masuk');
            $table->string('jam_masuk_selanjutnya');
            $table->string('foto');
            $table->string('ssid');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('presensi2s');
    }
}