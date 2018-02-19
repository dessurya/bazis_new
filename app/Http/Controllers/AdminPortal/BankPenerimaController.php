<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\BankPenerimaZIS;

use Auth;
use Validator;
use DB;
use Image;
use File;
use Rule;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class BankPenerimaController extends Controller
{
	public function index(request $request){
		$message = [
            'flag.in'        => 'Invalid filter',
            'author.email'        => 'Invalid filter',
        ];
        $validator = Validator::make($request->all(), [
            'flag'   => 'nullable|in:Publis,Unpublis',
            'author'   => 'nullable|email',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('adpor.penzis.banpen.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

        $authorList = BankPenerimaZIS::select('user_id')->get();

    	$get = BankPenerimaZIS::orderBy('flag', 'desc')->orderBy('id','desc');

    	if ($request->flag == 'Publis') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->flag == 'Unpublis') {
    		$get->where('flag', 'N');
    	}

    	if ($request->author != null) {
    		$getFilterAuthor = User::where('email',$request->author)->first();
    		if(!$getFilterAuthor){
    			return redirect()->route('adpor.penzis.banpen.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterAuthor->id);
	    	}
    	}

		$get = $get->get();

        return view('admin-portal.penerimaan-zis.bank.index', compact(
        	'get',
        	'authorList',
        	'request',
        	'getFilterAuthor'
        ));
	}

	public function simpan(request $request){
		$message = [
			'nama.required' => 'Wajib di isi',
			'nama.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'nama.unique' => 'Judul sudah dipakai',
		];

		$validator = Validator::make($request->all(), [
			'nama' => 'required|max:150|unique:zisju_rekening_bank_penerima_zis,bank_rekening',
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.penzis.banpen.index')
			->withErrors($validator)
			->withInput()
			->with('false-form', true);
		}

		DB::transaction(function () use($request) {
			$salt = str_random(4);
			$image = $request->file('picture');
			$img_url = str_slug($request->nama,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
			$upload1 = Image::make($image);
			$upload1->save('asset/picture/penerimaan-zis/bank/'.$img_url);

			$save = new BankPenerimaZIS;
			$save->user_id = Auth::user()->id;
			$save->bank_nama = $request->nama;
			$save->bank_logo = $img_url;
			$save->save();

		    LogUserRecord::banpenAdd($save);
		});

		return redirect()->route('adpor.penzis.banpen.index')
			->with('berhasil', 'Berhasil Menambah '.$request->nama);
	}

	public function flag($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = BankPenerimaZIS::find($id);

		if (!$find) {
			return view('errors.404');
		}

		if ($find->flag == 'N') {
			$find->flag = 'Y';
			$notif = $find->nama.' telah di publikasikan';
		}
		else if ($find->flag == 'Y') {
			$find->flag = 'N';
			$notif = $find->nama.' telah tidak di publikasikan';
		}
		$find->save();
		LogUserRecord::banpenFlag($find);

		return redirect()->route('adpor.penzis.banpen.index')
			->with('berhasil', $notif);
	}

	public function ubahSimpan(request $request, $id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$save = BankPenerimaZIS::find($id);

		if (!$save) {
			return view('errors.404');
		}

		$message = [
			'nama.required' => 'Wajib di isi',
			'nama.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'nama.unique' => 'Judul sudah dipakai '.$request->nama,
		];

		$validator = Validator::make($request->all(), [
			'nama' => 'required|max:150|unique:zisju_rekening_bank_penerima_zis,bank_rekening,'.$save->id,
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.penzis.banpen.index', ['id'=>encrypt($id)])
			->withErrors($validator)
			->withInput()
			->with('action', route('adpor.penzis.banpen.ubahSimpan', ['id'=>encrypt($save->id)]))
			->with('nama', $save->bank_nama)
			->with('false-form-update', true);
		}

		DB::transaction(function () use($request, $save) {

		    LogUserRecord::banpenUpdate($save, $request);
			
			if($request->file('picture')){
				File::delete('asset/picture/penerimaan-zis/bank/'.$save->bank_logo);
				$salt = str_random(4);
				$image = $request->file('picture');
				$img_url = str_slug($request->nama,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();
				$upload1 = Image::make($image);
				$upload1->save('asset/picture/penerimaan-zis/bank/'.$img_url);
				$save->bank_logo = $img_url;
			}			

			$save->user_id = Auth::user()->id;
			$save->bank_nama = $request->nama;
			$save->save();

		});

		return redirect()->route('adpor.penzis.banpen.index')
			->with('berhasil', 'Berhasil Mengubah '.$request->nama);
	}
}
