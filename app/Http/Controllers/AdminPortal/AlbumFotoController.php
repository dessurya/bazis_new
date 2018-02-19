<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\AlbumFoto;
use App\Models\AlbumFotoDetail;

use Auth;
use Validator;
use DB;
use Image;
use File;
use Rule;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class AlbumFotoController extends Controller
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
            return redirect()->route('adpor.albfot.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

        $authorList = AlbumFoto::select('user_id')->get();
    	
    	$get = AlbumFoto::orderBy('id','desc');

    	if ($request->flag == 'Publis') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->flag == 'Unpublis') {
    		$get->where('flag', 'N');
    	}

    	if ($request->author != null) {
    		$getFilterAuthor = User::where('email',$request->author)->first();
    		if(!$getFilterAuthor){
    			return redirect()->route('adpor.albfot.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterAuthor->id);
    		}
    	}

		$get = $get->get();

        return view('admin-portal.album-foto.index', compact(
        	'get',
        	'authorList',
        	'request',
        	'getFilterAuthor'
        ));
	}

	public function simpan(request $request){
		$message = [
			'title.required' => 'Wajib di isi',
			'title.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'title.unique' => 'Judul sudah dipakai',
			'content.required' => 'Wajib di isi',
			'content.min' => 'Terlalu Singkat',
		];

		$validator = Validator::make($request->all(), [
			'title' => 'required|max:150|unique:zisju_album_foto,title',
			'content' => 'required|min:20',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.albfot.index')
			->withErrors($validator)
			->withInput()
			->with('false-form', true);
		}

		DB::transaction(function () use($request) {
			$save = new AlbumFoto;
			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->slug = str_slug($request->title,'-');
			$save->save();

		    LogUserRecord::albfotAdd($save);
		});

		return redirect()->route('adpor.albfot.index')
			->with('berhasil', 'Berhasil Menambah '.$request->title);
	}

	public function flag($id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = AlbumFoto::find($id);

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
		LogUserRecord::albfotFlag($find);

		return redirect()->route('adpor.albfot.index')
			->with('berhasil', $notif);
	}

	public function hapus($id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = AlbumFoto::find($id);

		if (!$find) {
			return view('errors.404');
		}

		DB::transaction(function() use($find){
			$call = AlbumFotoDetail::where('album_foto_id', $find->id)->get();
			foreach ($call as $key) {
				File::delete('asset/picture/album-foto/'.$key->picture);
				$key->delete();
			}
			$find->delete();
		});
		LogUserRecord::albfotDelete($find);
		return redirect()->route('adpor.albfot.index')
			->with('berhasil', 'Berhasil Menghapus '.$find->title);
	}

	public function ubahSimpan(request $request, $id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}
		
		$save = AlbumFoto::find($id);

		if (!$save) {
			return view('errors.404');
		}

		$message = [
			'title.required' => 'Wajib di isi',
			'title.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'title.unique' => 'Judul sudah dipakai '.$request->title,
			'content.required' => 'Wajib di isi',
			'content.min' => 'Terlalu Singkat',
		];

		$validator = Validator::make($request->all(), [
			'title' => 'required|max:150|unique:zisju_album_foto,title,'.$save->id,
			'content' => 'required|min:20',
		], $message);


		if($validator->fails())
		{
			if (isset($request->indetail)) {
				return redirect()->route('adpor.albfotdet', ['id'=>$id])
					->withErrors($validator)
					->withInput()
					->with('false-form-update', true)
					->with('db_id', $save->id)
					->with('db_title', $save->title);
			
			}
			else{
				return redirect()->route('adpor.albfot.index')
					->withErrors($validator)
					->withInput()
					->with('false-form-update', true)
					->with('db_action', route('adpor.albfot.ubahSimpan', ['id'=>encrypt($save->id)]))
					->with('db_title', $save->title);
			}
		}

		DB::transaction(function () use($request, $save) {

		    LogUserRecord::albfotUpdate($save, $request);
			
			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->slug = str_slug($request->title,'-');
			$save->save();
		});
		if (isset($request->indetail)) {
			return redirect()->route('adpor.albfotdet', ['id'=>encrypt($id)])
				->with('berhasil', 'Berhasil Mengubah '.$request->title);
		}
		else{
			return redirect()->route('adpor.albfot.index')
				->with('berhasil', 'Berhasil Mengubah '.$request->title);
		}
	}
}
