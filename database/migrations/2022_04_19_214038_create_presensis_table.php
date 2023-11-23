<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('jam');
            $table->string('jam_masuk_besok');
            $table->string('jam_kerja')->default('00:00');
            $table->longText('foto');
            $table->string('device')->nullable();
            $table->string('maps')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('status', ['masuk', 'pulang'])->default('masuk');
            $table->string('presensi_status')->nullable();
            $table->enum('tipe', ['wfo', 'wfh'])->default('wfo');
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
        Schema::dropIfExists('presensis');
    }
}