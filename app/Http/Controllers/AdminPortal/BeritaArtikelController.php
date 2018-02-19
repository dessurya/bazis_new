<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\BeritaArtikel;

use Auth;
use Validator;
use DB;
use Image;
use File;
use Rule;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class BeritaArtikelController extends Controller
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
            return redirect()->route('adpor.berkel.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

        $authorList = BeritaArtikel::select('user_id')->get();

    	$get = BeritaArtikel::orderBy('id','desc');

    	if ($request->flag == 'Publis') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->flag == 'Unpublis') {
    		$get->where('flag', 'N');
    	}

    	if ($request->author != null) {
    		$getFilterAuthor = User::where('email',$request->author)->first();
    		if(!$getFilterAuthor){
    			return redirect()->route('adpor.berkel.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterAuthor->id);
	    	}
    	}

		$get = $get->get();

        return view('admin-portal.berita-artikel.index', compact(
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
			'picture.required' => 'Wajib di isi',
			'picture.dimensions' => 'Ukuran yg di terima 1024px x 1024px',
			'picture.image' => 'Format Gambar Tidak Sesuai',
			'picture.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'title' => 'required|max:150|unique:zisju_berita_artikel,title',
			'content' => 'required|min:20',
			'picture' => 'required|image|mimes:jpeg,bmp,png|max:5000|dimensions:max_width=1024,max_height=1024',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.berkel.index')
			->withErrors($validator)
			->withInput()
			->with('false-form', true);
		}

		DB::transaction(function () use($request) {
			$salt = str_random(4);
			$image = $request->file('picture');
			$img_url = str_slug($request->title,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
			$upload1 = Image::make($image);
			$upload1->save('asset/picture/berita-artikel/'.$img_url);

			$save = new BeritaArtikel;
			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->picture = $img_url;
			$save->slug = str_slug($request->title,'-');
			$save->save();

		    LogUserRecord::berkelAdd($save);
		});

		return redirect()->route('adpor.berkel.index')
			->with('berhasil', 'Berhasil Menambah '.$request->title);
	}

	public function flag($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = BeritaArtikel::find($id);

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
		LogUserRecord::berkelFlag($find);

		return redirect()->route('adpor.berkel.index')
			->with('berhasil', $notif);
	}

	public function hapus($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = BeritaArtikel::find($id);

		if (!$find) {
			return view('errors.404');
		}

		DB::transaction(function() use($find){
			File::delete('asset/picture/berita-artikel/'.$find->picture);
			$find->delete();
		});
		LogUserRecord::berkelDelete($find);
		return redirect()->route('adpor.berkel.index')
			->with('berhasil', 'Berhasil Menghapus '.$find->title);
	}

	public function ubah($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

    	$get = BeritaArtikel::find($id);

    	if (!$get) {
			return view('errors.404');
		}

        return view('admin-portal.berita-artikel.ubah', compact(
        	'get'
        ));
	}

	public function ubahSimpan(request $request, $id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$save = BeritaArtikel::find($id);

		if (!$save) {
			return view('errors.404');
		}

		$message = [
			'title.required' => 'Wajib di isi',
			'title.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'title.unique' => 'Judul sudah dipakai '.$request->title,
			'content.required' => 'Wajib di isi',
			'content.min' => 'Terlalu Singkat',
			'picture.dimensions' => 'Ukuran yg di terima 1024px x 1024px',
			'picture.image' => 'Format Gambar Tidak Sesuai',
			'picture.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'title' => 'required|max:150|unique:zisju_berita_artikel,title,'.$save->id,
			'content' => 'required|min:20',
			'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:5000|dimensions:max_width=1024,max_height=1024',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.berkel.ubah', ['id'=>encrypt($id)])
			->withErrors($validator)
			->withInput()
			->with('false-form', true);
		}

		DB::transaction(function () use($request, $save) {

		    LogUserRecord::berkelUpdate($save, $request);
			
			if($request->file('picture')){
				File::delete('asset/picture/berita-artikel/'.$save->picture);
				$salt = str_random(4);
				$image = $request->file('picture');
				$img_url = str_slug($request->title,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
				$upload1 = Image::make($image);
				$upload1->save('asset/picture/berita-artikel/'.$img_url);
				$save->picture = $img_url;
			}

			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->slug = str_slug($request->title,'-');
			$save->save();

		});

		return redirect()->route('adpor.berkel.index')
			->with('berhasil', 'Berhasil Mengubah '.$request->title);
	}
}
