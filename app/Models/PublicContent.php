<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicContent extends Model
{
    protected $table = 'zisju_public_content';

    protected $fillable = ['title', 'picture', 'content', 'category', 'description', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
