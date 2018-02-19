<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Frontend
	// Beranda
		Route::get('/', 'Frontend\FrontendController@beranda')
			->name('frontend.beranda');
	// Beranda
	// Seputar Kami
		Route::prefix('seputar-kami')->group(function(){
			Route::get('bazis-jakarta-utara', 'Frontend\FrontendController@SKbazis')
				->name('frontend.sk.bazis');
			Route::get('program-kami', 'Frontend\FrontendController@SKprogram')
				->name('frontend.sk.program');
		});
	// Seputar Kami
	// Kabar Berita
		Route::prefix('kabar-berita')->group(function(){
			Route::get('/', 'Frontend\FrontendController@KBindex')
				->name('frontend.kb.index');
		});
	// Kabar Berita
// Frontend


// Route::get('adduser', function(){
// 	$confirmation_code = str_random(30).time();
// 	$user = new App\Models\User;
// 	$user->name = 'Adam Surya Des';
// 	$user->email = 'fourline66@gmail.com';
// 	$user->confirmed = 'Y';
// 	$user->login_count = 0;
// 	$user->password = Hash::make('asdasd');
// 	$user->confirmation_code = $confirmation_code;
// 	$user->save();
// 	$add = new App\Models\Pengunjung;
// 	$add->nama = 'Adam Surya Des';
// 	$add->email = 'fourline66@gmail.com';
// 	$add->save();

// 	$addd = new App\Models\KotakMasuk;
// 	$addd->pengunjung_id = 1;
// 	$addd->pesan = 'fourline66@gmail.com';

// 	$addd->save();

// 	return redirect()
// 		->route('loginForm')
// 		->with('status', 'success to add adam');
// });



// portal admin
	Route::prefix('admin')->group(function(){

	    // login logout
			Route::get('login', 'Auth\LoginController@showLoginForm')
				->name('loginForm');
		    Route::post('login', 'Auth\LoginController@login')
		    	->name('login');
		    Route::post('logout', 'Auth\LoginController@logout')
		    	->name('logout');
	    // login logout

	    // Middleware Auth
	    	Route::middleware(['auth'])->group(function(){

	    		// dashboard
		    		Route::get('dashboard', 'AdminPortal\DashboardController@index')
		    			->name('adpor.dashboard');
	    		// dashboard

		    	// Content Web
			    	// Album Foto
			    		Route::get('album-foto/', 'AdminPortal\AlbumFotoController@index')
			    			->name('adpor.albfot.index');
			    		Route::post('album-foto/simpan', 'AdminPortal\AlbumFotoController@simpan')
			    			->name('adpor.albfot.simpan');
			    		Route::get('album-foto/hapus/{id}', 'AdminPortal\AlbumFotoController@hapus')
			    			->name('adpor.albfot.hapus');
			    		Route::get('album-foto/flag/{id}', 'AdminPortal\AlbumFotoController@flag')
			    			->name('adpor.albfot.flag');
			    		Route::post('album-foto/ubah/{id}', 'AdminPortal\AlbumFotoController@ubahSimpan')
			    			->name('adpor.albfot.ubahSimpan');

			    		// Album Foto Detail
			    			Route::get('album-foto/buka/{id}', 'AdminPortal\AlbumFotoDetailController@index')
				    			->name('adpor.albfotdet');
			    			Route::post('album-foto/buka/{id}/upload', 'AdminPortal\AlbumFotoDetailController@simpan')
				    			->name('adpor.albfotdet.simpan');
				    		Route::post('album-foto/buka/{id}/{subId}/tools', 'AdminPortal\AlbumFotoDetailController@tools')
				    			->name('adpor.albfotdet.tools');
			    		// Album Foto Detail
			    	// Album Foto

				    // Banner
				    	Route::get('banner/', 'AdminPortal\BannerController@index')
			    			->name('adpor.banner.index');
			    		Route::post('banner/add', 'AdminPortal\BannerController@simpan')
			    			->name('adpor.banner.simpan');
			    		Route::get('banner/flag/{id}', 'AdminPortal\BannerController@flag')
			    			->name('adpor.banner.flag');
			    		Route::get('banner/hapus/{id}', 'AdminPortal\BannerController@hapus')
			    			->name('adpor.banner.hapus');
				    // Banner

			    	// Berita Artikel
			    		Route::get('berita-artikel/', 'AdminPortal\BeritaArtikelController@index')
			    			->name('adpor.berkel.index');
			    		Route::post('berita-artikel/simpan', 'AdminPortal\BeritaArtikelController@simpan')
			    			->name('adpor.berkel.simpan');
			    		Route::get('berita-artikel/hapus/{id}', 'AdminPortal\BeritaArtikelController@hapus')
			    			->name('adpor.berkel.hapus');
			    		Route::get('berita-artikel/flag/{id}', 'AdminPortal\BeritaArtikelController@flag')
			    			->name('adpor.berkel.flag');
			    		Route::get('berita-artikel/ubah/{id}', 'AdminPortal\BeritaArtikelController@ubah')
			    			->name('adpor.berkel.ubah');
			    		Route::post('berita-artikel/ubah/{id}', 'AdminPortal\BeritaArtikelController@ubahSimpan')
			    			->name('adpor.berkel.ubahSimpan');
			    	// Berita Artikel

			    	// data bazis
			    		Route::get('data-bazis/', 'AdminPortal\DataBazisController@index')
			    			->name('adpor.datbaz.index');
			    		Route::post('data-bazis/update/{id}', 'AdminPortal\DataBazisController@update')
			    			->name('adpor.datbaz.update');
			    		Route::get('data-bazis/flag/{id}', 'AdminPortal\DataBazisController@flag')
			    			->name('adpor.datbaz.flag');
			    	// data bazis

			    	// halaman
			    		Route::get('halaman/', 'AdminPortal\HalamanController@index')
			    			->name('adpor.halaman.index');
			    		Route::post('halaman/update/{id}', 'AdminPortal\HalamanController@update')
			    			->name('adpor.halaman.update');
			    	// halaman

			    	// Iklan
				    	Route::get('iklan/', 'AdminPortal\IklanController@index')
			    			->name('adpor.iklan.index');
			    		Route::post('iklan/add', 'AdminPortal\IklanController@simpan')
			    			->name('adpor.iklan.simpan');
			    		Route::get('iklan/flag/{id}', 'AdminPortal\IklanController@flag')
			    			->name('adpor.iklan.flag');
			    		Route::get('iklan/hapus/{id}', 'AdminPortal\IklanController@hapus')
			    			->name('adpor.iklan.hapus');
				    // Iklan

			    	// media sosial
			    		Route::get('media-sosial/', 'AdminPortal\MediaSosialController@index')
			    			->name('adpor.medsos.index');
			    		Route::post('media-sosial/simpan', 'AdminPortal\MediaSosialController@simpan')
			    			->name('adpor.medsos.simpan');
			    		Route::post('media-sosial/update/{id}', 'AdminPortal\MediaSosialController@update')
			    			->name('adpor.medsos.update');
			    		Route::get('media-sosial/hapus/{id}', 'AdminPortal\MediaSosialController@hapus')
			    			->name('adpor.medsos.hapus');
			    		Route::get('media-sosial/flag/{id}', 'AdminPortal\MediaSosialController@flag')
			    			->name('adpor.medsos.flag');
			    	// media sosial

			    	// Pengaturan Umum
			    		Route::get('pengaturan-umum/', 'AdminPortal\PublicContentController@index')
			    			->name('adpor.penumu.index');
			    	// Pengaturan Umum

			    	// program kami
			    		Route::get('program-kami/', 'AdminPortal\ProgramKamiController@index')
			    			->name('adpor.prokam.index');
			    		Route::post('program-kami/simpan', 'AdminPortal\ProgramKamiController@simpan')
			    			->name('adpor.prokam.simpan');
			    		Route::post('program-kami/update/{id}', 'AdminPortal\ProgramKamiController@update')
			    			->name('adpor.prokam.update');
			    		Route::get('program-kami/hapus/{id}', 'AdminPortal\ProgramKamiController@hapus')
			    			->name('adpor.prokam.hapus');
			    		Route::get('program-kami/flag/{id}', 'AdminPortal\ProgramKamiController@flag')
			    			->name('adpor.prokam.flag');
			    	// program kami

			    	// Laporan ZIS
			    		Route::get('laporan-zis/', 'AdminPortal\LaporanZISController@index')
			    			->name('adpor.lapzis.index');
			    		Route::post('laporan-zis/simpan', 'AdminPortal\LaporanZISController@simpan')
			    			->name('adpor.lapzis.simpan');
			    		Route::get('laporan-zis/hapus/{id}', 'AdminPortal\LaporanZISController@hapus')
			    			->name('adpor.lapzis.hapus');
			    		Route::get('laporan-zis/flag/{id}', 'AdminPortal\LaporanZISController@flag')
			    			->name('adpor.lapzis.flag');
			    		Route::get('laporan-zis/ubah/{id}', 'AdminPortal\LaporanZISController@ubah')
			    			->name('adpor.lapzis.ubah');
			    		Route::post('laporan-zis/ubah/{id}', 'AdminPortal\LaporanZISController@ubahSimpan')
			    			->name('adpor.lapzis.ubahSimpan');
			    	// Laporan ZIS

			    	// testimoni
			    		Route::get('testimoni/', 'AdminPortal\TestimoniController@index')
			    			->name('adpor.testim.index');
			    		Route::post('testimoni/simpan', 'AdminPortal\TestimoniController@simpan')
			    			->name('adpor.testim.simpan');
			    		Route::get('testimoni/hapus/{id}', 'AdminPortal\TestimoniController@hapus')
			    			->name('adpor.testim.hapus');
			    		Route::get('testimoni/flag/{id}', 'AdminPortal\TestimoniController@flag')
			    			->name('adpor.testim.flag');
			    	// testimoni

			    	// Video Youtube
			    		Route::get('video-youtube/', 'AdminPortal\VideoYoutubeController@index')
			    			->name('adpor.viyou.index');
			    		Route::post('video-youtube/simpan', 'AdminPortal\VideoYoutubeController@simpan')
			    			->name('adpor.viyou.simpan');
			    		Route::get('video-youtube/hapus/{id}', 'AdminPortal\VideoYoutubeController@hapus')
			    			->name('adpor.viyou.hapus');
			    		Route::get('video-youtube/flag/{id}', 'AdminPortal\VideoYoutubeController@flag')
			    			->name('adpor.viyou.flag');
			    		Route::post('video-youtube/ubah/{id}', 'AdminPortal\VideoYoutubeController@ubahSimpan')
			    			->name('adpor.viyou.ubahSimpan');
			    	// Video Youtube
		    	// Content Web

		    	// Penerimaan ZIS
		    		// Bank Penerimaan
			    		Route::get('penerimaan-zis/bank-penerima', 'AdminPortal\BankPenerimaController@index')
			    			->name('adpor.penzis.banpen.index');
			    		Route::post('penerimaan-zis/bank-penerima/simpan', 'AdminPortal\BankPenerimaController@simpan')
			    			->name('adpor.penzis.banpen.simpan');
			    		Route::get('penerimaan-zis/bank-penerima/flag/{id}', 'AdminPortal\BankPenerimaController@flag')
			    			->name('adpor.penzis.banpen.flag');
			    		Route::post('penerimaan-zis/bank-penerima/ubah/{id}', 'AdminPortal\BankPenerimaController@ubahSimpan')
			    			->name('adpor.penzis.banpen.ubahSimpan');
		    		// Bank Penerimaan
			    	// Rekening Bank
			    		Route::get('penerimaan-zis/rekening-bank', 'AdminPortal\RekeningBankPenerimaController@index')
			    			->name('adpor.penzis.rekban.index');
			    		Route::post('penerimaan-zis/rekening-bank/simpan', 'AdminPortal\RekeningBankPenerimaController@simpan')
			    			->name('adpor.penzis.rekban.simpan');
			    		Route::get('penerimaan-zis/rekening-bank/flag/{id}', 'AdminPortal\RekeningBankPenerimaController@flag')
			    			->name('adpor.penzis.rekban.flag');
			    		Route::post('penerimaan-zis/rekening-bank/ubah/{id}', 'AdminPortal\RekeningBankPenerimaController@ubahSimpan')
			    			->name('adpor.penzis.rekban.ubahSimpan');
			    	// Rekening Bank
		    		// Riwayat Penerimaan
			    		Route::get('penerimaan-zis/riwayat-penerimaan', 'AdminPortal\PenerimaanZISController@index')
			    			->name('adpor.penzis.riwpen.index');
		    			Route::get('penerimaan-zis/riwayat-penerimaan/confirmed/{id}', 'AdminPortal\PenerimaanZISController@confirmed')
			    			->name('adpor.penzis.riwpen.confirmed');
			    		Route::get('penerimaan-zis/riwayat-penerimaan/delete/{id}', 'AdminPortal\PenerimaanZISController@delete')
			    			->name('adpor.penzis.riwpen.delete');

			    		Route::get('penerimaan-zis/riwayat-penerimaan/delete', 'AdminPortal\PenerimaanZISController@deleteIndex')
			    			->name('adpor.penzis.riwpen.deleteIndex');
			    		Route::get('penerimaan-zis/riwayat-penerimaan/recovery/{id}', 'AdminPortal\PenerimaanZISController@recovery')
			    			->name('adpor.penzis.riwpen.recovery');
			    			
		    		// Riwayat Penerimaan
		    	// Penerimaan ZIS

		    	// Pengunjung Web
			    	// Pengunjung
			    		Route::get('pengunjung', 'AdminPortal\PengunjungController@index')
			    			->name('adpor.pengunjung.index');
			    	// Pengunjung
			    	// kotak masuk
				    	Route::get('kotak-masuk', 'AdminPortal\KotakMasukController@index')
			    			->name('adpor.kotakmasuk.inbox');
			    		Route::post('kotak-masuk/{id}/respon', 'AdminPortal\KotakMasukController@respon')
			    			->name('adpor.kotakmasuk.respon');
	    			// kotak masuk
		    	// Pengunjung Web

	    		// users
		    		Route::get('user', 'AdminPortal\UserController@index')
		    			->name('adpor.user.index');
		    		Route::get('user/reset/{id}', 'AdminPortal\UserController@resetPassword')
		    			->name('adpor.user.resetpassword');
		    		Route::get('user/delete/{id}', 'AdminPortal\UserController@delete')
		    			->name('adpor.user.delete');
		    		Route::get('user/status/{id}', 'AdminPortal\UserController@status')
		    			->name('adpor.user.status');
		    		Route::post('user/store', 'AdminPortal\UserController@add')
		    			->name('adpor.user.store');
		    		Route::post('user/update/me', 'AdminPortal\UserController@update')
		    			->name('adpor.user.update.me');
		    		// log user
	    			Route::get('log-user', 'AdminPortal\UserController@loguser')
		    			->name('adpor.user.loguser');
		    		// log user
		    	// users

	    	});
	    // Middleware Auth
	});
// portal admin
