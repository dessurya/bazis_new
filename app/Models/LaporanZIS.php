<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanZIS extends Model
{
    protected $table = 'zisju_laporan_zis';

    protected $fillable = ['title', 'laporan', 'content', 'category', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
