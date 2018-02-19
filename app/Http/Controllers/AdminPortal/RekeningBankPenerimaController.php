<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\BankPenerimaZIS;
use App\Models\RekeningBankPenerimaZIS;

use Auth;
use Validator;
use DB;
use Image;
use File;
use Rule;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class RekeningBankPenerimaController extends Controller
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
            return redirect()->route('adpor.penzis.rekban.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

        $authorList = RekeningBankPenerimaZIS::select('user_id')->get();

    	$get = RekeningBankPenerimaZIS::orderBy('flag', 'desc')->orderBy('id','desc');

    	if ($request->flag == 'Publis') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->flag == 'Unpublis') {
    		$get->where('flag', 'N');
    	}

    	if ($request->author != null) {
    		$getFilterAuthor = User::where('email',$request->author)->first();
    		if(!$getFilterAuthor){
    			return redirect()->route('adpor.penzis.rekban.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterAuthor->id);
	    	}
    	}

    	if ($request->bank != null){
    		$getFilterBank = BankPenerimaZIS::where('bank_nama',$request->bank)->first();
    		if(!$getFilterBank){
    			return redirect()->route('adpor.penzis.rekban.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
    			$get->where('bank_penerima_id', $getFilterBank->id);
    		}
    	}

		$get = $get->get();

		$getBank = BankPenerimaZIS::select('id','bank_nama')->orderBy('bank_nama', 'asc')->get();

        return view('admin-portal.penerimaan-zis.rekening.index', compact(
        	'get',
        	'getBank',
        	'authorList',
        	'request',
        	'getFilterAuthor'
        ));
	}

	public function simpan(request $request){
		$message = [
			'rekening.required' => 'Wajib di isi',
			'rekening.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'rekening.unique' => 'Judul sudah dipakai',
			'bank.required' => 'Wajib di isi',
		];

		$validator = Validator::make($request->all(), [
			'rekening' => 'required|max:150|unique:zisju_rekening_bank_penerima_zis,bank_rekening',
			'bank' => 'required'
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.penzis.rekban.index')
			->withErrors($validator)
			->withInput()
			->with('false-form', true);
		}

		DB::transaction(function () use($request) {
			$save = new RekeningBankPenerimaZIS;
			$save->user_id = Auth::user()->id;
			$save->bank_rekening = $request->rekening;
			$save->bank_penerima_id = $request->bank;
			$save->save();

		    LogUserRecord::rekbanAdd($save);
		});

		return redirect()->route('adpor.penzis.rekban.index')
			->with('berhasil', 'Berhasil Menambah '.$request->rekening);
	}

	public function flag($id){
	    try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = RekeningBankPenerimaZIS::find($id);

		if (!$find) {
			return view('errors.404');
		}

		if ($find->flag == 'N') {
			$find->flag = 'Y';
			$notif = $find->rekening.' telah di publikasikan';
		}
		else if ($find->flag == 'Y') {
			$find->flag = 'N';
			$notif = $find->rekening.' telah tidak di publikasikan';
		}
		$find->save();
		LogUserRecord::rekbanFlag($find);

		return redirect()->route('adpor.penzis.rekban.index')
			->with('berhasil', $notif);
	}

	public function ubahSimpan(request $request, $id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$save = RekeningBankPenerimaZIS::find($id);

		if (!$save) {
			return view('errors.404');
		}

		$message = [
			'rekening.required' => 'Wajib di isi',
			'rekening.max' => 'Terlalu Panjang, Maks 150 Karakter',
	        'rekening.unique' => 'Judul sudah dipakai '.$request->rekening,
			'bank.required' => 'Wajib di isi',
		];

		$validator = Validator::make($request->all(), [
			'rekening' => 'required|max:150|unique:zisju_rekening_bank_penerima_zis,bank_rekening,'.$save->id,
			'bank' => 'required'
		], $message);


		if($validator->fails())
		{
		return redirect()->route('adpor.penzis.rekban.index', ['id'=>encrypt($id)])
			->withErrors($validator)
			->withInput()
			->with('action', route('adpor.penzis.rekban.ubahSimpan', ['id'=>encrypt($save->id)]))
			->with('rekening', $save->bank_rekening)
			->with('bank', $save->bank_penerima_id)
			->with('nama', $save->bank->bank_nama)
			->with('false-form-update', true);
		}

		DB::transaction(function () use($request, $save) {

		    LogUserRecord::rekbanUpdate($save, $request);
			
			$save->user_id = Auth::user()->id;
			$save->bank_rekening = $request->rekening;
			$save->bank_penerima_id = $request->bank;
			$save->save();
		});

		return redirect()->route('adpor.penzis.rekban.index')
			->with('berhasil', 'Berhasil Mengubah '.$request->rekening);
	}
}
