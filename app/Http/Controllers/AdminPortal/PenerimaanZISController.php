<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Pengunjung;
use App\Models\BankPenerimaZIS;
use App\Models\RekeningBankPenerimaZIS;

use App\Models\PemberianZIS;

use Auth;
use Validator;
use DB;
use Image;
use File;
use Rule;
use Storage;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class PenerimaanZISController extends Controller
{
	public function index(request $request){
		$message = [
            'status.in'        => 'Invalid filter',
            'confirmed.email'        => 'Invalid filter',
            'pemberi.email'        => 'Invalid filter',
        ];
        $validator = Validator::make($request->all(), [
            'status'   => 'nullable|in:Pending,Confirmed',
            'confirmed'   => 'nullable|email',
            'pemberi'   => 'nullable|email',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('adpor.penzis.riwpen.index')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }


    	$get = PemberianZIS::orderBy('flag', 'asc')->orderBy('id','desc');

    	if ($request->status == 'Confirmed') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->status == 'Pending') {
    		$get->where('flag', 'N');
    	}
    	else if($request->status == null){
    		$get->whereIn('flag', ['Y', 'N']);
    	}

    	if ($request->bank != null) {
    		$getFilterBank = BankPenerimaZIS::where('bank_nama',$request->bank)->first();
    		if(!$getFilterBank){
    			return redirect()->route('adpor.penzis.riwpen.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
    			$getRekId = RekeningBankPenerimaZIS::select('id')->where('bank_penerima_id', $getFilterBank->id)->get();
    			$inRekId = array();
    			foreach ($getRekId as $key) {
    				array_push($inRekId, $key->id);
    			}
    			$get->whereIn('rekening_bank_penerima_zis_id', $inRekId);
	    	}
    	}

    	if ($request->pemberi != null) {
    		$getFilterPemberi = Pengunjung::where('email',$request->pemberi)->first();
    		if(!$getFilterPemberi){
    			return redirect()->route('adpor.penzis.riwpen.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('pengunjung_id', $getFilterPemberi->id);
	    	}
    	}

    	if ($request->confirmed != null) {
    		$getFilterconfirmed = User::where('email',$request->confirmed)->first();
    		if(!$getFilterconfirmed){
    			return redirect()->route('adpor.penzis.riwpen.index')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterconfirmed->id);
	    	}
    	}

		$get = $get->get();

		$getBank = BankPenerimaZIS::select('id','bank_nama')->orderBy('bank_nama', 'asc')->get();
        $confirmedList = PemberianZIS::select('user_id')->orderBy('user_id')->get();
        $pemberiList = PemberianZIS::select('pengunjung_id')->orderBy('pengunjung_id')->get();

        return view('admin-portal.penerimaan-zis.penerimaan.index', compact(
        	'get',
        	'getBank',
        	'confirmedList',
        	'pemberiList',
        	'request',
        	'getFilterconfirmed',
        	'getFilterPemberi'
        ));
	}

	public function confirmed($id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = PemberianZIS::find($id);

		if (!$find) {
			return view('errors.404');
		}
		$find->user_id = Auth::user()->id;
		$find->flag = 'Y';
		$find->save();
		LogUserRecord::penzisConfirmed($find);

		return redirect()->route('adpor.penzis.riwpen.index')
			->with('berhasil', 'ZIS : '.$find->no_zis.' Berhasil Di Konfirmasi(Disahkan)');
	}

	public function delete($id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = PemberianZIS::find($id);

		if (!$find) {
			return view('errors.404');
		}

		File::move('bukti/'.$find->bukti, 'bukti-hapus/'.$find->bukti);
		
		$find->user_id = Auth::user()->id;
		$find->flag = 'D';
		$find->save();
		LogUserRecord::penzisDelete($find);

		return redirect()->route('adpor.penzis.riwpen.index')
			->with('berhasil', 'ZIS : '.$find->no_zis.' Berhasil Di Hapus');
	}

	public function recovery($id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return view('errors.404');
		}

		$find = PemberianZIS::find($id);

		if (!$find) {
			return view('errors.404');
		}

		File::move('bukti-hapus/'.$find->bukti, 'bukti/'.$find->bukti);
		
		$find->user_id = null;
		$find->flag = 'N';
		$find->save();
		LogUserRecord::penzisRecovery($find);

		return redirect()->route('adpor.penzis.riwpen.index')
			->with('berhasil', 'ZIS : '.$find->no_zis.' Berhasil Di Pulihkan');
	}

	public function deleteIndex(request $request){
		$message = [
            'delete.email'        => 'Invalid filter',
            'pemberi.email'        => 'Invalid filter',
        ];
        $validator = Validator::make($request->all(), [
            'delete'   => 'nullable|email',
            'pemberi'   => 'nullable|email',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('adpor.penzis.riwpen.deleteIndex')
				->with('berhasil', 'Terjadi Keselahan Filter');
        }


    	$get = PemberianZIS::orderBy('flag', 'asc')->orderBy('id','desc')->where('flag', 'D');

    	if ($request->bank != null) {
    		$getFilterBank = BankPenerimaZIS::where('bank_nama',$request->bank)->first();
    		if(!$getFilterBank){
    			return redirect()->route('adpor.penzis.riwpen.deleteIndex')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
    			$getRekId = RekeningBankPenerimaZIS::select('id')->where('bank_penerima_id', $getFilterBank->id)->get();
    			$inRekId = array();
    			foreach ($getRekId as $key) {
    				array_push($inRekId, $key->id);
    			}
    			$get->whereIn('rekening_bank_penerima_zis_id', $inRekId);
	    	}
    	}

    	if ($request->pemberi != null) {
    		$getFilterPemberi = Pengunjung::where('email',$request->pemberi)->first();
    		if(!$getFilterPemberi){
    			return redirect()->route('adpor.penzis.riwpen.deleteIndex')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('pengunjung_id', $getFilterPemberi->id);
	    	}
    	}

    	if ($request->delete != null) {
    		$getFilterdelete = User::where('email',$request->delete)->first();
    		if(!$getFilterdelete){
    			return redirect()->route('adpor.penzis.riwpen.deleteIndex')
					->with('berhasil', 'Terjadi Keselahan Filter');
    		}
    		else{
	    		$get->where('user_id', $getFilterdelete->id);
	    	}
    	}

		$get = $get->get();

		$getBank = BankPenerimaZIS::select('id','bank_nama')->orderBy('bank_nama', 'asc')->get();
        $deleteList = PemberianZIS::select('user_id')->orderBy('user_id')->get();
        $pemberiList = PemberianZIS::select('pengunjung_id')->orderBy('pengunjung_id')->get();

        return view('admin-portal.penerimaan-zis.penerimaan.delete', compact(
        	'get',
        	'getBank',
        	'deleteList',
        	'pemberiList',
        	'request',
        	'getFilterdelete',
        	'getFilterPemberi'
        ));
	}
}
