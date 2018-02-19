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

class DataBazisController extends Controller
{
	public function index(Request $request){
		$message = [
            'flag.in'        => 'Invalid filter',
            'author.email'        => 'Invalid filter',
        ];
        $validator = Validator::make($request->all(), [
            'flag'   => 'nullable|in:Publis,Unpublis',
            'author'   => 'nullable|email',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('adpor.datbaz.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

        $authorList = PublicContent::select('user_id')->where('category', 'data_bazis')->get();

    	$get = PublicContent::orderBy('id','desc')->where('category', 'data_bazis');

    	if ($request->flag == 'Publis') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->flag == 'Unpublis') {
    		$get->where('flag', 'N');
    	}

    	if ($request->author != null) {
    		$getFilterAuthor = User::where('email',$request->author)->first();
    		if(!$getFilterAuthor){
    			return redirect()->route('adpor.datbaz.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterAuthor->id);
	    	}
    	}

		$get = $get->get();

        return view('admin-portal.data-bazis.index', compact(
        	'get',
        	'authorList',
        	'request',
        	'getFilterAuthor'
        ));
	}

	public function flag($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = PublicContent::find($id);

		if (!$find) {
			return view('errors.404');
		}

		if ($find->flag == 'N') {
			$find->flag = 'Y';
			$notif = $find->title.' telah di publikasikan';
		}
		else if ($find->flag == 'Y') {
			$find->flag = 'N';
			$notif = $find->title.' telah tidak di publikasikan';
		}
		$find->save();
		LogUserRecord::datbazFlag($find);

		return redirect()->route('adpor.datbaz.index')
			->with('berhasil', $notif);
	}

	public function update(request $request, $id){
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
			'content.required' => 'Wajib di isi',
			'content.min' => 'Terlalu Singkat',
			'picture.dimensions' => 'Ukuran yg di terima 1024px x 1024px',
			'picture.image' => 'Format Gambar Tidak Sesuai',
			'picture.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'content' => 'required|min:20',
			'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:5000|dimensions:max_width=1024,max_height=1024',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.datbaz.index', ['id'=>encrypt($id)])
			->withErrors($validator)
			->withInput()
			->with('url', 'update')
			->with('title', $save->title)
			->with('action', route('adpor.datbaz.update', ['id'=>encrypt($save->id)]))
			->with('false-form', true);
		}

		DB::transaction(function () use($request, $save) {

		    LogUserRecord::datbazUpdate($save, $request);
			
			if($request->file('picture')){
				File::delete('asset/picture/data-bazis/'.$save->picture);
				$salt = str_random(4);
				$image = $request->file('picture');
				$img_url = str_slug($request->title,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
				$upload1 = Image::make($image);
				$upload1->save('asset/picture/data-bazis/'.$img_url);
				$save->picture = $img_url;
			}			

			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->save();

		});

		return redirect()->route('adpor.datbaz.index')
			->with('berhasil', 'Berhasil Mengubah '.$request->title);
	}
}
