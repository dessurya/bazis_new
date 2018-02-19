<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRekeningBankPenerimaZis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zisju_rekening_bank_penerima_zis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('bank_penerima_id')->unsigned();
            $table->string('bank_rekening')->unique();
            $table->string('flag')->default('N');
            $table->timestamps();
        });
        Schema::table('zisju_rekening_bank_penerima_zis', function($table) {
            $table->foreign('user_id')->references('id')->on('zisju_users');
            $table->foreign('bank_penerima_id')->references('id')->on('zisju_bank_penerima_zis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zisju_rekening_bank_penerima_zis');
    }
}
