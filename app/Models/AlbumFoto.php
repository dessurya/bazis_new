<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumFoto extends Model
{
	protected $table = 'zisju_album_foto';

    protected $fillable = ['title', 'picture', 'content', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
