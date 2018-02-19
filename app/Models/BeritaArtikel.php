<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaArtikel extends Model
{
    protected $table = 'zisju_berita_artikel';

    protected $fillable = ['title', 'picture', 'content', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
