<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePemberianZis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zisju_pemberian_zis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('pengunjung_id')->unsigned();
            $table->integer('rekening_bank_penerima_zis_id')->unsigned();
            $table->string('no_zis')->unique();
            $table->string('nominal');
            $table->string('bukti');
            $table->string('tampilkan_identitas')->default('Y');
            $table->string('flag')->default('N');
            $table->timestamps();
        });

        Schema::table('zisju_pemberian_zis', function($table) {
            $table->foreign('user_id')->references('id')->on('zisju_users');
            $table->foreign('pengunjung_id')->references('id')->on('zisju_pengunjung');
            $table->foreign('rekening_bank_penerima_zis_id')->references('id')->on('zisju_rekening_bank_penerima_zis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zisju_pemberian_zis');
    }
}
