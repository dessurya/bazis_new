<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YoutubeEmbed extends Model
{
	protected $table = 'zisju_youtube_embed';

    protected $fillable = ['title', 'url_youtube', 'content', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
