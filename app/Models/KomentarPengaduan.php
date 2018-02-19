<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarPengaduan extends Model
{
    protected $table = 'zisju_komentar_pengaduan';

    protected $fillable = ['komentar_id'];

    public function komentar()
	{
		return $this->belongsTo('App\Models\Komentar', 'komentar_id');
	}
}
