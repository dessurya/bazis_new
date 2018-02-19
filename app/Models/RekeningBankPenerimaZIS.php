<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningBankPenerimaZIS extends Model
{
	protected $table = 'zisju_rekening_bank_penerima_zis';

    protected $fillable = ['bank_rekening', 'bank_penerima_id', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function bank()
	{
		return $this->belongsTo('App\Models\BankPenerimaZIS', 'bank_penerima_id');
	}
}
