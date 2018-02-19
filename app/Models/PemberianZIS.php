<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemberianZIS extends Model
{
    protected $table = 'zisju_pemberian_zis';

    protected $fillable = ['no_zis', 'nominal', 'bukti', 'pengunjung_id', 'rekening_bank_penerima_zis_id', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

    public function pengunjung()
	{
		return $this->belongsTo('App\Models\Pengunjung', 'pengunjung_id');
	}

	public function rekening()
	{
		return $this->belongsTo('App\Models\RekeningBankPenerimaZIS', 'rekening_bank_penerima_zis_id');
	}
}
