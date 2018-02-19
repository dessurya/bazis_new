<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeritaArtikel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zisju_berita_artikel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title')->unique();
            $table->string('picture');
            $table->text('content');
            $table->string('flag')->default('N');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::table('zisju_berita_artikel', function($table) {
            $table->foreign('user_id')->references('id')->on('zisju_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zisju_berita_artikel');
    }
}
