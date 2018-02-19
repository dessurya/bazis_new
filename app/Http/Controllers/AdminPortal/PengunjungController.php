<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Pengunjung;


class PengunjungController extends Controller
{
    public function index(){
    	
    	$get = Pengunjung::orderBy('id','desc')->get();
        return view('admin-portal.pengunjung.index', compact(
        	'get'
        ));
	}
}
