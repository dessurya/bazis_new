<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlbumFotoDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zisju_album_foto_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('album_foto_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('picture');
            $table->text('content')->nullable();
            $table->string('flag')->default('Y');
            $table->timestamps();
        });

        Schema::table('zisju_album_foto_detail', function($table) {
            $table->foreign('user_id')->references('id')->on('zisju_users');
            $table->foreign('album_foto_id')->references('id')->on('zisju_album_foto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zisju_album_foto_detail');
    }
}
