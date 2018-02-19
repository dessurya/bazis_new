<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumFotoDetail extends Model
{
    protected $table = 'zisju_album_foto_detail';

    protected $fillable = ['title', 'picture', 'content', 'album_foto_id', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

    public function album_foto()
	{
		return $this->belongsTo('App\Models\AlbumFoto', 'album_foto_id');
	}
}
