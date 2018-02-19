<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\YoutubeEmbed;

use Auth;
use Validator;
use DB;
use Image;
use File;
use Rule;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class VideoYoutubeController extends Controller
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
            return redirect()->route('adpor.viyou.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

        $authorList = YoutubeEmbed::select('user_id')->get();

    	$get = YoutubeEmbed::orderBy('id','desc');

    	if ($request->flag == 'Publis') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->flag == 'Unpublis') {
    		$get->where('flag', 'N');
    	}

    	if ($request->author != null) {
			$getFilterAuthor = User::where('email',$request->author)->first();
			if(!$getFilterAuthor){
    			return redirect()->route('adpor.viyou.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterAuthor->id);
	    	}
    	}

		$get = $get->get();

        return view('admin-portal.youtube-embed.index', compact(
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
			'url_youtube.required' => 'Wajib di isi',
			'url_youtube.regex' => 'Harus url youtube. contoh : https://www.youtube.com/watch?v=.....',
		];

		$validator = Validator::make($request->all(), [
			'title' => 'required|max:150|unique:zisju_youtube_embed,title',
			'content' => 'required|min:20',
			'url_youtube' => 'required|regex:(www.youtube.com)',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.viyou.index')
			->withErrors($validator)
			->withInput()
			->with('false-form', true);
		}

		DB::transaction(function () use($request) {

			$save = new YoutubeEmbed;
			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->url_youtube = $request->url_youtube;
			$save->slug = str_slug($request->title,'-');
			$save->save();

		    LogUserRecord::youemAdd($save);
		});

		return redirect()->route('adpor.viyou.index')
			->with('berhasil', 'Berhasil Menambah '.$request->title);
	}

	public function flag($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = YoutubeEmbed::find($id);

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
		LogUserRecord::youemFlag($find);

		return redirect()->route('adpor.viyou.index')
			->with('berhasil', $notif);
	}

	public function hapus($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = YoutubeEmbed::find($id);

		if (!$find) {
			return view('errors.404');
		}

		DB::transaction(function() use($find){
			$find->delete();
		});
		LogUserRecord::youemDelete($find);
		return redirect()->route('adpor.viyou.index')
			->with('berhasil', 'Berhasil Menghapus '.$find->title);
	}

	public function ubahSimpan(request $request, $id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$save = YoutubeEmbed::find($id);

		if (!$save) {
			return view('errors.404');
		}

		$message = [
			'fildUp_title.required' => 'Wajib di isi',
			'fildUp_title.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'fildUp_title.unique' => 'Judul sudah dipakai '.$request->fildUp_title,
			'fildUp_content.required' => 'Wajib di isi',
			'fildUp_content.min' => 'Terlalu Singkat',
			'fildUp_url_youtube.required' => 'Wajib di isi',
			'fildUp_url_youtube.regex' => 'Harus url youtube. contoh : https://www.youtube.com/watch?v=.....',
		];

		$validator = Validator::make($request->all(), [
			'fildUp_title' => 'required|max:150|unique:zisju_youtube_embed,title,'.$save->id,
			'fildUp_content' => 'required|min:20',
			'fildUp_url_youtube' => 'required|regex:(www.youtube.com)',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.viyou.index', ['id'=>$id])
			->withErrors($validator)
			->withInput()
			->with('db_title', $save->title)
			->with('db_action', route('adpor.viyou.ubahSimpan', ['id'=> encrypt($save->id)]))
			->with('false-form-update', true);
		}

		DB::transaction(function () use($request, $save) {

		    LogUserRecord::youemUpdate($save, $request);
			
			$save->user_id = Auth::user()->id;
			$save->title = $request->fildUp_title;
			$save->content = $request->fildUp_content;
			$save->url_youtube = $request->fildUp_url_youtube;
			$save->slug = str_slug($request->fildUp_title,'-');
			$save->save();

		});

		return redirect()->route('adpor.viyou.index')
			->with('berhasil', 'Berhasil Mengubah '.$request->fildUp_title);
	}
}
