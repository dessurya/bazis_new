<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKomentar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zisju_komentar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pengunjung_id')->unsigned();
            $table->string('content_category');
            $table->string('content_id');
            $table->text('comment');
            $table->timestamps();
        });

        Schema::table('zisju_komentar', function($table) {
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
        Schema::dropIfExists('zisju_komentar');
    }
}
