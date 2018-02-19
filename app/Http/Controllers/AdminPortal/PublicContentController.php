<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\PublicContent;

use Auth;
use Validator;
use DB;
use Image;
use File;
use Rule;

use LogUserRecord;

class PublicContentController extends Controller
{
	public function index(){
		$lgBazis 	= PublicContent::where('category', 'logo-bazis')->first();
        $alamat 	= PublicContent::where('category', 'data_bazis')->where('title', 'alamat')->first();
        $telpon 	= PublicContent::where('category', 'data_bazis')->where('title', 'telpon')->first();
        $email 		= PublicContent::where('category', 'data_bazis')->where('title', 'email')->first();
        $medsos 	= PublicContent::where('category', 'media_sosial')->where('flag', 'Y')->get();

        
	}
}
