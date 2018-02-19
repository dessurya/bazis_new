<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbleKomentarPengaduan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zisju_komentar_pengaduan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('komentar_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('zisju_komentar_pengaduan', function($table) {
            $table->foreign('komentar_id')->references('id')->on('zisju_komentar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zisju_komentar_pengaduan');
    }
}
