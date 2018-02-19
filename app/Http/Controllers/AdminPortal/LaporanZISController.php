<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\LaporanZIS;

use Auth;
use Validator;
use DB;
use Image;
use File;
use Rule;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class LaporanZISController extends Controller
{
	public function index(Request $request){
		$message = [
            'flag.in'        => 'Invalid filter',
            'katagori.in'        => 'Invalid filter',
            'author.email'        => 'Invalid filter',
        ];
        $validator = Validator::make($request->all(), [
            'flag'   => 'nullable|in:Publis,Unpublis',
            'katagori'   => 'nullable|in:Pengeluaran,Pemasukan',
            'author'   => 'nullable|email',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('adpor.lapzis.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

        $authorList = LaporanZIS::select('user_id')->get();

    	$get = LaporanZIS::orderBy('id','desc');

    	if ($request->flag == 'Publis') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->flag == 'Unpublis') {
    		$get->where('flag', 'N');
    	}

    	if ($request->author != null) {
    		$getFilterAuthor = User::where('email',$request->author)->first();
    		if(!$getFilterAuthor){
    			return redirect()->route('adpor.lapzis.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterAuthor->id);
	    	}
    	}

		$get = $get->get();

        return view('admin-portal.laporan-zis.index', compact(
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
			'katagori.required' => 'Wajib di isi',
            'katagori.in'        => 'Terjai Keselahan',
			'laporan.required' => 'Wajib di isi',
			'laporan.file' => 'Format FIle Tidak Sesuai',
			'laporan.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'title' => 'required|max:150|unique:zisju_laporan_zis,title',
			'content' => 'required|min:20',
            'katagori'   => 'required|in:Pengeluaran,Pemasukan',
			'laporan' => 'required|file|mimes:pdf|max:5000',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.lapzis.index')
			->withErrors($validator)
			->withInput()
			->with('false-form', true);
		}

		DB::transaction(function () use($request) {
			$salt = str_random(4);
			$laporan = $request->file('laporan');
			$dok_url = str_slug($request->title,'-').'-'.$salt. '.' . $laporan->getClientOriginalExtension();
			
			$laporan->move('asset/dokumen/laporan-zis/',$dok_url);

			$save = new LaporanZIS;
			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->category = $request->katagori;
			$save->laporan = $dok_url;
			$save->slug = str_slug($request->title,'-');
			$save->save();

		    LogUserRecord::lapzisAdd($save);
		});

		return redirect()->route('adpor.lapzis.index')
			->with('berhasil', 'Berhasil Menambah '.$request->title);
	}

	public function flag($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = LaporanZIS::find($id);

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
		LogUserRecord::lapzisFlag($find);

		return redirect()->route('adpor.lapzis.index')
			->with('berhasil', $notif);
	}

	public function hapus($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = LaporanZIS::find($id);

		if (!$find) {
			return view('errors.404');
		}

		DB::transaction(function() use($find){
			File::delete('asset/dokumen/laporan-zis/'.$find->laporan);
			$find->delete();
		});
		LogUserRecord::lapzisDelete($find);
		return redirect()->route('adpor.lapzis.index')
			->with('berhasil', 'Berhasil Menghapus '.$find->title);
	}

	public function ubah($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

    	$get = LaporanZIS::find($id);

    	if (!$get) {
			return view('errors.404');
		}

        return view('admin-portal.laporan-zis.ubah', compact(
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

		$save = LaporanZIS::find($id);

		if (!$save) {
			return view('errors.404');
		}

		$message = [
			'title.required' => 'Wajib di isi',
			'title.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'title.unique' => 'Judul sudah dipakai '.$request->title,
			'content.required' => 'Wajib di isi',
			'content.min' => 'Terlalu Singkat',
			'katagori.required' => 'Wajib di isi',
            'katagori.in'        => 'Terjai Keselahan',
			'laporan.file' => 'Format FIle Tidak Sesuai',
			'laporan.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'title' => 'required|max:150|unique:zisju_laporan_zis,title,'.$save->id,
			'content' => 'required|min:20',
            'katagori'   => 'required|in:Pengeluaran,Pemasukan',
			'laporan' => 'nullable|file|mimes:pdf|max:5000',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.lapzis.ubah', ['id'=>encrypt($id)])
			->withErrors($validator)
			->withInput()
			->with('false-form', true);
		}

		DB::transaction(function () use($request, $save) {

		    LogUserRecord::lapzisUpdate($save, $request);
			
			if($request->file('laporan')){
				File::delete('asset/dokumen/laporan-zis/'.$save->laporan);
				$salt = str_random(4);
				$laporan = $request->file('laporan');
				$dok_url = str_slug($request->title,'-').'-'.$salt. '.' . $laporan->getClientOriginalExtension();
				
				$laporan->move('asset/dokumen/laporan-zis/',$dok_url);
			}			

			$save->user_id = Auth::user()->id;
			$save->title = $request->title;
			$save->content = $request->content;
			$save->category = $request->katagori;
			$save->laporan = $dok_url;
			$save->slug = str_slug($request->title,'-');
			$save->save();

		});

		return redirect()->route('adpor.lapzis.index')
			->with('berhasil', 'Berhasil Mengubah '.$request->title);
	}
}
