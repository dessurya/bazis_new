<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\KotakMasuk;

use Auth;
use Validator;
use DB;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class KotakMasukController extends Controller
{
	public function index(request $request){
		$message = [
            'status.in'        => 'Invalid filter',
            'author.email'        => 'Invalid filter',
        ];
        $validator = Validator::make($request->all(), [
            'status'   => 'nullable|in:Respon,Unrespon',
            'author'   => 'nullable|email',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('adpor.kotakmasuk.inbox')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

    	$get = KotakMasuk::orderBy('id','desc');
    	
    	if ($request->status == 'Respon') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->status == 'Unrespon') {
    		$get->where('flag', 'N');
    	}

		$get = $get->get();

        return view('admin-portal.kotak-masuk.index', compact(
        	'get',
        	'request'
        ));
	}

	public function respon($id, request $request){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = KotakMasuk::find($id);

		if (!$find) {
			return view('errors.404');
		}

		$message = [
			'respon.required' => 'Wajib di isi',
			'respon.min' => 'Terlalu Singkat',
		];

		$validator = Validator::make($request->all(), [
			'respon' => 'required|min:10',
		], $message);

		if($validator->fails()){
			return redirect()->route('adpor.kotakmasuk.inbox')
				->withErrors($validator)
				->withInput()
				->with('false-form', true)
				->with('db_action', route('adpor.kotakmasuk.respon', ['id'=> encrypt($find->id)]))
				->with('db_title', $find->pengunjung->nama.'/'.$find->pengunjung->email)
				->with('db_pesan', $find->pesan);
		}

		DB::transaction(function () use($find, $request){
			$find->flag = 'Y';
			$find->respon = $request->respon;
			$find->user_id = Auth::user()->id;
			$find->save();
			LogUserRecord::kotmasRespon($find);
		});

		return redirect()->route('adpor.kotakmasuk.inbox')
			->with('berhasil', 'Berhasil Merespon Pesan Dari '.$find->pengunjung->nama.'/'.$find->pengunjung->email);
	}
}
