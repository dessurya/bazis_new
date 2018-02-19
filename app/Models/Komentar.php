<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'zisju_komentar';

    protected $fillable = ['content_category', 'content_id', 'comment', 'pengunjung_id'];

    public function pengunjung()
	{
		return $this->belongsTo('App\Models\Pengunjung', 'pengunjung_id');
	}
}
