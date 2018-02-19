<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankPenerimaZIS extends Model
{
    protected $table = 'zisju_bank_penerima_zis';

    protected $fillable = ['bank_nama', 'bank_rekening', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
