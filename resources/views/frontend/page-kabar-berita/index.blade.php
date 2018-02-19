@extends('frontend._layout.basic')

@section('title')
	<title>Bazis Kota Administrasi Jakarta Utara | {{ $page->description }}</title>
@endsection

@section('meta')
	<meta name="title" content="Bazis Kota Administrasi Jakarta Utara">
	<meta name="description" content="{!! Str::words(strip_tags($page->content), 15, '...') !!}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/public-sub.css') }}">
	<style type="text/css">
		.card{
			position: relative;
			display: inline-block;
			margin: 0 auto 10px;
			width: 27.33%;

			padding: 5px 10px;
		}
		.card #border{
			position: relative;
			border: 1px solid gray;
		}
		.card #border #img{
			height: 160px;
			width: 100%;

			background-position: center;
			background-size: cover;
			background-repeat: no-repeat;
		}
		.card #border h3{
			margin: 0;
			padding: 10px;
			height: 35px;
			overflow-y: hidden;
		}
		.card #border #content{
			height: 35px;
			padding: 10px;
			overflow-y: hidden;
		}
		.card #border #content p{
			margin: 0;
		}
		.card #border .text-center{
			padding: 20px;
		}
	</style>
@endsection

@section('body')
	<div id="banner" class="section" style="background-image: url('{{ asset('asset/picture/halaman/'.$page->picture) }}');"></div>
	<div class="after-section odd"></div>

	<div class="content section odd">
		<div class="wrapper medium">
			<h2 class="text-center">{{ $page->title }}</h2>
			{!! $page->content !!}

			<div class="text-center">
				@foreach($BeritaArtikel as $list)
				<div class="card">
					<div id="border">
						<div id="img" title="{{ $list->title }}" style="background-image: url('{{ asset('asset/picture/berita-artikel/'.$list->picture) }}');"></div>
						<h3 title="{{ $list->title }}">{{ $list->title }}</h3>
						<div id="content">
							{!! Str::words(strip_tags($list->content), 15, '...') !!}
						</div>
						<div class="text-center">
							<a class="btn-link" href="">
								Lihat
							</a>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>

@endsection

@section('include_js')
	
@endsection
