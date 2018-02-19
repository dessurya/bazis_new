<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\AlbumFoto;
use App\Models\Banner;
use App\Models\BeritaArtikel;
use App\Models\Iklan;
use App\Models\PublicContent;
use App\Models\YoutubeEmbed;

class FrontendController extends Controller
{
	public function beranda(){
		$AlbumFoto 			= AlbumFoto::orderBy('updated_at','desc')->where('flag', 'Y')->limit(3)->get();
		$Banner 			= Banner::orderBy('updated_at','desc')->where('flag', 'Y')->limit(5)->get();
		$BeritaArtikel 		= BeritaArtikel::orderBy('updated_at','desc')->where('flag', 'Y')->limit(6)->get();
		$Iklan	 			= Iklan::where('flag', 'Y')->inRandomOrder()->first();
		$Testimoni 			= PublicContent::orderBy('updated_at','desc')->where('category', 'testimoni')->where('flag', 'Y')->limit(4)->get();
		$ProgramBazis 		= PublicContent::orderBy('updated_at','desc')->where('category', 'program-kami')->where('flag', 'Y')->limit(5)->get();
		$YoutubeEmbed 		= YoutubeEmbed::orderBy('updated_at','desc')->where('flag', 'Y')->limit(3)->get();

		return view('frontend.page-beranda.index', compact(
			'AlbumFoto',
			'Banner',
			'BeritaArtikel',
			'Iklan',
			'Testimoni',
			'ProgramBazis',
			'YoutubeEmbed'
		));
	}

	// Seputar Kami
		public function SKbazis(){
			$page = PublicContent::where('category', 'halaman')->where('description', 'Seputar Kami - Bazis Jakarta Utara')->first();

			return view('frontend.page-seputar-kami.bazis', compact('page'));
		}
		public function SKprogram(){
			$page = PublicContent::where('category', 'halaman')->where('description', 'Seputar Kami - Program Kami')->first();
			$ProgramBazis = PublicContent::orderBy('updated_at','desc')->where('category', 'program-kami')->where('flag', 'Y')->get();

			return view('frontend.page-seputar-kami.program', compact('page', 'ProgramBazis'));
		}
	// Seputar Kami

	// Kabar Berita
		public function KBindex(){
			$page = PublicContent::where('category', 'halaman')->where('description', 'Kabar Berita')->first();
			$BeritaArtikel 	= BeritaArtikel::orderBy('updated_at','desc')->where('flag', 'Y')->limit(6)->get();

			return view('frontend.page-kabar-berita.index', compact('page', 'BeritaArtikel'));
		}
	// Kabar Berita
}
