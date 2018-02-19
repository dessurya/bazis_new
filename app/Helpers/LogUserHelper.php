<?php
namespace App\Helpers;

use App\Models\User;
use App\Models\UserLog;
use App\Models\BankPenerimaZIS;

use Auth;

class LogUserHelper {
	
	// user
	    public static function userAdd($data) {
	    	$text = 'Menambahakan User Baru Nama '.$data->name.' email '.$data->email;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function userChangeStatus($data) {
	    	$text = 'Mengubah Status User '.$data->name.'/'.$data->email;
	    	if($data->confirmed == 'Y'){
	    		$text = $text.' Menjadi Aktif';
	    	}
	    	else{
	    		$text = $text.' Menjadi Non-Aktif';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function userResetPassword($data) {
	    	$text = 'Me-Reset Ulang Password User '.$data->name.'/'.$data->email;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function userDelete($data) {
	    	$text = 'Menghapus User '.$data->name.'/'.$data->email;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// user

	// Album Foto
	    public static function albfotAdd($data) {
	    	$text = 'Menambahakan Album Foto Baru :'.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function albfotFlag($data) {
	    	$text = 'Album Foto : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function albfotDelete($data) {
	    	$text = 'Menghapus Album Foto : '.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function albfotUpdate($dataOld, $dataNew) {
	    	if($dataOld->title == $dataNew->title){
		    	$text = 'Mengubah Album Foto : '.$dataNew->title;
	    	}
	    	else{
		    	$text = 'Mengubah Album Foto : '.$dataOld->title.' Menjadi : '.$dataNew->title;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Album Foto

	// Bank Penerima ZIS
	    public static function banpenAdd($data) {
	    	$text = 'Menambahakan Bank Penerima ZIS Baru :'.$data->bank_nama;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function banpenFlag($data) {
	    	$text = 'Bank Penerima ZIS : '.$data->bank_nama;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function banpenUpdate($dataOld, $dataNew) {
	    	if($dataOld->bank_nama == $dataNew->bank_nama){
		    	$text = 'Mengubah Bank Penerima ZIS : '.$dataNew->bank_nama;
	    	}
	    	else{
		    	$text = 'Mengubah Bank Penerima ZIS : '.$dataOld->bank_nama.' Menjadi : '.$dataNew->bank_nama;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Bank Penerima ZIS

	// Banner
	    public static function bannerAdd($data) {
	    	$text = 'Menambahakan Banner Baru :'.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function bannerFlag($data) {
	    	$text = 'Banner : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function bannerDelete($data) {
	    	$text = 'Menghapus Banner : '.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Banner

	// Berita Acara
	    public static function berkelAdd($data) {
	    	$text = 'Menambahakan Berita Artikel Baru :'.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function berkelFlag($data) {
	    	$text = 'Berita Acara : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function berkelDelete($data) {
	    	$text = 'Menghapus Berita Acara : '.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function berkelUpdate($dataOld, $dataNew) {
	    	if($dataOld->title == $dataNew->title){
		    	$text = 'Mengubah Berita Acara : '.$dataNew->title;
	    	}
	    	else{
		    	$text = 'Mengubah Berita Acara : '.$dataOld->title.' Menjadi : '.$dataNew->title;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Berita Acara

	// Data Bazis
	    public static function datbazFlag($data) {
	    	$text = 'Data Bazis : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function datbazUpdate($dataOld, $dataNew) {
	    	if($dataOld->title == $dataNew->title){
		    	$text = 'Mengubah Data Bazis : '.$dataNew->title;
	    	}
	    	else{
		    	$text = 'Mengubah Data Bazis : '.$dataOld->title.' Menjadi : '.$dataNew->title;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Data Bazis

	// Halaman
	    public static function halaman($dataOld, $dataNew) {
	    	if($dataOld->title == $dataNew->fildUp_title){
		    	$text = 'Mengubah Halaman : '.$dataNew->fildUp_title;
	    	}
	    	else{
		    	$text = 'Mengubah Halaman : '.$dataOld->title.' Menjadi : '.$dataNew->fildUp_title;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Halaman

	// Iklan
	    public static function iklanAdd($data) {
	    	$text = 'Menambahakan Iklan Baru :'.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function iklanFlag($data) {
	    	$text = 'Iklan : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function iklanDelete($data) {
	    	$text = 'Menghapus Iklan : '.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Iklan

	// Media Sosial
	    public static function medsosAdd($data) {
	    	$text = 'Menambahakan Media Sosial Baru :'.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function medsosFlag($data) {
	    	$text = 'Media Sosial : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function medsosDelete($data) {
	    	$text = 'Menghapus Media Sosial : '.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function medsosUpdate($dataOld, $dataNew) {
	    	if($dataOld->title == $dataNew->title){
		    	$text = 'Mengubah Media Sosial : '.$dataNew->title;
	    	}
	    	else{
		    	$text = 'Mengubah Media Sosial : '.$dataOld->title.' Menjadi : '.$dataNew->title;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Media Sosial

	// Kotak Masuk
	    public static function kotmasRespon($data) {
	    	$text = 'Merespon Pesan Dari :'.$data->pengunjung->nama.'/'.$data->pengunjung->email.' Pesan : '.$data->pesan.' ---|--- Di Respon Dengan : '.$data->respon;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Kotak Masuk

	// Laporan ZIS
	    public static function lapzisAdd($data) {
	    	$text = 'Menambahakan Laporan ZIS Baru :'.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function lapzisFlag($data) {
	    	$text = 'Laporan ZIS : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function lapzisDelete($data) {
	    	$text = 'Menghapus Laporan ZIS : '.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function lapzisUpdate($dataOld, $dataNew) {
	    	if($dataOld->title == $dataNew->title){
		    	$text = 'Mengubah Laporan ZIS : '.$dataNew->title;
	    	}
	    	else{
		    	$text = 'Mengubah Laporan ZIS : '.$dataOld->title.' Menjadi : '.$dataNew->title;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Laporan ZIS

	// Program Bazis
	    public static function prokamAdd($data) {
	    	$text = 'Menambahakan Program Bazis Baru :'.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function prokamFlag($data) {
	    	$text = 'Program Bazis : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function prokamDelete($data) {
	    	$text = 'Menghapus Program Bazis : '.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function prokamUpdate($dataOld, $dataNew) {
	    	if($dataOld->title == $dataNew->title){
		    	$text = 'Mengubah Program Bazis : '.$dataNew->title;
	    	}
	    	else{
		    	$text = 'Mengubah Program Bazis : '.$dataOld->title.' Menjadi : '.$dataNew->title;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Program Bazis

	// Youtube Embed
	    public static function youemAdd($data) {
	    	$text = 'Menambahakan Video Youtube Baru :'.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function youemFlag($data) {
	    	$text = 'Video Youtube : '.$data->title;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function youemDelete($data) {
	    	$text = 'Menghapus Video Youtube : '.$data->title;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function youemUpdate($dataOld, $dataNew) {
	    	if($dataOld->title == $dataNew->fildUp_title){
		    	$text = 'Mengubah Video Youtube : '.$dataNew->fildUp_title;
	    	}
	    	else{
		    	$text = 'Mengubah Video Youtube : '.$dataOld->title.' Menjadi : '.$dataNew->fildUp_title;
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Youtube Embed

	// Rekening Bank Penerima ZIS
	    public static function rekbanAdd($data) {
	    	$text = 'Menambahakan Rekening Bank Penerima ZIS Baru :'.$data->bank_rekening.' Pada Bank :'.$data->bank->bank_nama;
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function rekbanFlag($data) {
	    	$text = 'Rekening Bank Penerima ZIS : '.$data->bank_rekening.' Pada Bank : '.$data->bank->bank_nama;
	    	if($data->flag == 'Y'){
	    		$text = $text.' Telah Dipublikasikan';
	    	}
	    	else{
	    		$text = $text.' Telah Di Non-Publikasikan';	
	    	}
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function rekbanUpdate($dataOld, $dataNew) {
	    	$excute = false;
	    	$text = 'Mengubah Rekening Bank Penerima ZIS : '.$dataOld->bank_rekening.' Dari Bank : '.$dataOld->bank->bank_nama;
	    	if ($dataOld->bank_penerima_id != $dataNew->bank) {
	    		$findB = BankPenerimaZIS::find($dataNew->bank);
	    		$text = $text.' --|-- Bank Diubah Menjadi Bank : '.$findB->bank_nama;
		    	$excute = true;
	    	}
	    	if ($dataOld->bank_rekening != $dataNew->rekening) {
	    		$text = $text.' --|-- Rekening Bank Diubah Menjadi : '.$dataNew->rekening;
		    	$excute = true;
	    	}
	    	if ($excute == true) {
		        $record = new UserLog;
		        $record->user_id = Auth::user()->id;
		        $record->logs = $text;
		        $record->save();
	    	}
	    }
	// Rekening Bank Penerima ZIS

	// Penerimaan ZIS
	    public static function penzisConfirmed($data) {
	    	$text = 'ZIS : '.$data->no_zis.' Telah Di Konfirmasi(Disahkan)';
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function penzisDelete($data) {
	    	$text = 'ZIS : '.$data->no_zis.' Telah Di Hapus';
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	    public static function penzisRecovery($data) {
	    	$text = 'ZIS : '.$data->no_zis.' Telah Di Pulihkan';
	        $record = new UserLog;
	        $record->user_id = Auth::user()->id;
	        $record->logs = $text;
	        $record->save();
	    }
	// Penerimaan ZIS
}