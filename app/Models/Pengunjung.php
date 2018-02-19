<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    protected $table = 'zisju_pengunjung';

    protected $fillable = ['nama', 'foto', 'email', 'telpon', 'identitas_no', 'identitas_jenis'];
}
