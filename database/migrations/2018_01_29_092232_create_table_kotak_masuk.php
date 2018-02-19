<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKotakMasuk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zisju_kotak_masuk', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('pengunjung_id')->unsigned();
            $table->text('pesan');
            $table->text('respon')->nullable();
            $table->string('flag')->default('N');
            $table->timestamps();
        });

        Schema::table('zisju_kotak_masuk', function($table) {
            $table->foreign('user_id')->references('id')->on('zisju_users');
            $table->foreign('pengunjung_id')->references('id')->on('zisju_pengunjung');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zisju_kotak_masuk');
    }
}
