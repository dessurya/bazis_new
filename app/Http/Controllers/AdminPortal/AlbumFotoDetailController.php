<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


class AlbumFotoDetailController extends Controller
{
	public function index(request $request, $id){
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

		$message = [
            'flag.in'        => 'Invalid filter',
        ];
        $validator = Validator::make($request->all(), [
            'flag'   => 'nullable|in:Publis,Unpublis',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('adpor.albfotdet', ['id'=>encrypt($find->id)])
				->with('berhasil', 'Terjadi Keselahan Filter');
        }

		$get = AlbumFotoDetail::where('album_foto_id', $id)
			->orderBy('flag', 'desc')
			->orderBy('id', 'desc');

		if ($request->flag == 'Publis') {
    		$get->where('flag', 'Y');
    	}
    	else if ($request->flag == 'Unpublis') {
    		$get->where('flag', 'N');
    	}

		$get = $get->get();

		return view('admin-portal.album-foto.detail.index', compact(
        	'find',
        	'get',
        	'request'
        ));
	}

	public function simpan(request $request, $id){
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (DecryptException $e) {
			return response()->json([
				'action'=>false,
				'resault'=>'Album Foto Tidak Ditemukan....',
				'msg'=>'Terjadi Kesalahan Saat Pengambilan Data... '
			]);
		}

    	$find = AlbumFoto::find($id);
    	if (!$find) {
			return response()->json([
				'action'=>false,
				'resault'=>'Album Foto Tidak Ditemukan....',
				'msg'=>'Terjadi Kesalahan Saat Pengambilan Data... '
			]);
		}

		$message = [
			'file.required' => 'Wajib di isi',
			'file.dimensions' => 'Ukuran yg di terima 1024px x 1024px',
			'file.image' => 'Format Gambar Tidak Sesuai',
			'file.max' => 'File Size Terlalu Besar',
		];

		$validator = Validator::make($request->all(), [
			'file' => 'required|image|mimes:jpeg,bmp,png|max:5000|dimensions:max_width=1024,max_height=1024',
		], $message);

		if($validator->fails())
		{
	        return response()->json([
				'action'=>false,
	        	'resault'=>$validator->getMessageBag()->toArray(),
	        	'msg'=>'Terjadi Kesalahan Data Yang Diinput Tidak Sesuai... '
	        ]);
		}

        $resault = DB::transaction(function () use($request, $find) {

			$salt = str_random(4);
			$image = $request->file('file');
			$img_url = str_slug($find->title,'-').'-'.$salt.'.'. $image->getClientOriginalExtension();
			$upload1 = Image::make($image);
			$upload1->save('asset/picture/album-foto/'.$img_url);

			$save = new AlbumFotoDetail;
			$save->user_id 			= Auth::user()->id;
			$save->album_foto_id 	= $find->id;
			$save->title 			= $img_url;
			$save->picture 			= $img_url;
			$save->save();

		    return $save;
		});

		$prepend = "";
	    $prepend = $prepend."<div class='card col-md-12 col-sm-12 col-xs-12'>";
	    $prepend = $prepend."<form class='detail-pict' action='". route('adpor.albfotdet.tools', ['id'=>encrypt($find->id), 'subId'=>encrypt($resault->id)]) ."' method='POST' class='form-horizontal form-label-left'>";
	    $prepend = $prepend."<div class='row'><div class='col-md-4 col-sm-4 col-xs-12'><div class='card-body'>";
	    $prepend = $prepend."<a href='".asset("asset/picture/album-foto/".$resault->picture)."' target='_blank'>";
	    $prepend = $prepend."<div id='img' style='background-image: url(".asset("asset/picture/album-foto/".$resault->picture).");'></div>";
	    $prepend = $prepend."</a>";
	    $prepend = $prepend."</div></div><div class='col-md-8 col-sm-8 col-xs-12'><div class='card-body'><h5 class='card-title'>Picture Details and Form Update</h5>";
	    $prepend = $prepend."<p class='card-text'>Title :</p><input id='title' name='title' class='form-control' type='text' value='". $resault->title ."'>";
	    $prepend = $prepend."<p class='card-text'>Content :</p><textarea id='content' name='content' class='form-control' >". $resault->content ."</textarea>";
	    $prepend = $prepend."</div><div class='card-body text-right'><hr><div class='btn-group' role='group' aria-label='Basic example'>";
	    $prepend = $prepend."<button type='button' id='save' class='toolsPict btn btn-success'>Save</button>";
	    $prepend = $prepend."<button type='button' id='flag' class='toolsPict btn btn-info' data-toggle='tooltip' data-placement='top' title='Click to Unpublis'>Publish</button>";
	    $prepend = $prepend."<button type='button' id='cover' class='toolsPict btn btn-warning'>Cover</button>";
	    $prepend = $prepend."<button type='button' id='delete' class='toolsPict btn btn-danger'>Delete</button>";
	    $prepend = $prepend."</div></div></div></div></form></div>";

        return response()->json([
			'action'=>true,
        	'resault'=>$prepend,
			'msg'=>'Foto Telah Terimpan... '
        ]);
	}

	public function tools(request $request, $id, $subId){
		// pengecekan
			$invalid = 0;
			try {
				$id = Crypt::decrypt($id);
			} 
			catch (DecryptException $e) {
				$invalid++;
			}
			try {
				$subId = Crypt::decrypt($subId);
			} 
			catch (DecryptException $e) {
				$invalid++;
			}
			
			$find = AlbumFoto::find($id);
			if (!$find) {
				$invalid++;
			}
			$findScd = AlbumFotoDetail::find($subId);
			if (!$findScd) {
				$invalid++;
			}
		// pengecekan

		if ($invalid != 0) {
			return response()->json([
				'msg'=>'Terjadi Kesalahan Saat Pengambilan Data...'
			]);
		}
		else{
			switch ($request->action) {
				case 'save':
					$findScd->title = $request->title;
					$findScd->content = $request->content;
					$findScd->save();
					$msg = 'Foto : '.$findScd->title.' Telah Di Update';
				break;
				case 'cover':
					$find->picture = $findScd->picture;
					$find->save();
					$msg = 'Foto : '.$findScd->title.' Telah Di Jadikan Sampul Album';
				break;
				case 'flag':
					if ($findScd->flag == 'N') {
						$findScd->flag = 'Y';
						$msg = 'Foto : '.$findScd->title.' Telah Di Publish';
					}
					else if ($findScd->flag == 'Y') {
						$findScd->flag = 'N';
						$msg = 'Foto : '.$findScd->title.' Telah Di Un-Publish';
					}
					$findScd->save();
				break;
				case 'delete':
					$cek = AlbumFoto::where('picture', $findScd->picture)->count();
					if ($cek == 0) {
						File::delete('asset/picture/album-foto/'.$findScd->picture);
						$findScd->delete();
						$msg = 'Foto : '.$findScd->title.' Telah Dihapus';
					}
					else{
						return response()->json([
							'msg'=>'Tidak Bisa Menghapus Foto Yang Dijadikan Sampul...'
						]);
					}
				break;
			}
			return response()->json([
				'action'=>$request->action,
				'flag'=>$findScd->flag,
				'msg'=>$msg
			]);
		}
	}
}
