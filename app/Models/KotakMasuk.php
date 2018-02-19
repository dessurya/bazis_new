<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KotakMasuk extends Model
{
	protected $table = 'zisju_kotak_masuk';

    protected $fillable = ['pesan', 'respon', 'pengunjung_id', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

    public function pengunjung()
	{
		return $this->belongsTo('App\Models\Pengunjung', 'pengunjung_id');
	}
}
