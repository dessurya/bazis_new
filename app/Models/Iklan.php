<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
	protected $table = 'zisju_iklan';

    protected $fillable = ['title', 'picture', 'flag', 'user_id'];

    public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
