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

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class HalamanController extends Controller
{
    public function index(Request $request){
		$message = [
            'author.email'        => 'Invalid filter',
        ];
        $validator = Validator::make($request->all(), [
            'author'   => 'nullable|email',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('adpor.halaman.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

        $authorList = PublicContent::select('user_id')->where('category', 'halaman')->get();

    	$get = PublicContent::orderBy('id','desc')->where('category', 'halaman');

    	if ($request->author != null) {
    		$getFilterAuthor = User::where('email',$request->author)->first();
    		if(!$getFilterAuthor){
    			return redirect()->route('adpor.halaman.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterAuthor->id);
	    	}
    	}

		$get = $get->get();

        return view('admin-portal.halaman.index', compact(
        	'get',
        	'authorList',
        	'request',
        	'getFilterAuthor'
        ));
	}

	public function update($id, request $request){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$save = PublicContent::find($id);

		if (!$save) {
			return view('errors.404');
		}

		$message = [
			'title.required' => 'Wajib di isi',
			'title.max' => 'Terlalu Panjang, Maks 150 Karakter',
			'picture.dimensions' => 'Ukuran yg di terima 2224px x 1024px',
			'picture.image' => 'Format Gambar Tidak Sesuai',
			'picture.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'title' => 'required|max:150',
			'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:5000|dimensions:max_width=2224,max_height=1024',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.halaman.index')
			->withErrors($validator)
			->withInput()
			->with('db_action', route('adpor.halaman.update', ['id'=> encrypt($save->id)]))
			->with('db_title', $save->title)
			->with('false-form', true);
		}

		DB::transaction(function () use($request, $save) {

			LogUserRecord::halaman($save, $request);
			
			if($request->file('picture')){
				File::delete('asset/picture/halaman/'.$save->picture);
				$salt = str_random(4);
				$image = $request->file('picture');
				$img_url = str_slug($request->title,'-').'-'.time().$salt. '.' . $image->getClientOriginalExtension();
				$upload1 = Image::make($image);
				$upload1->save('asset/picture/halaman/'.$img_url);
				$save->picture = $img_url;
			}

			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->category = 'halaman';

			$save->save();
		});

		return redirect()->route('adpor.halaman.index')
			->with('berhasil', 'Berhasil Menambah '.$request->title);
	}
}
