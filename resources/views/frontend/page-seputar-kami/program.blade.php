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
		img.img{
			width: 320px;
			float: left;
			padding-right: 20px;
		}
		.card{
			padding-bottom: 20px;
			border-bottom: 1.5px solid rgb(215,215,215);
		}
		.card h4{
			font-size: 20px;
			margin: 0;
			padding: 20px 0 0px;
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

			@foreach($ProgramBazis as $list)
			<div id="{{ str_slug($list->title) }}" class="card">
				<h4 class="text-left" title="{{ $list->title }}">
					{{ $list->title }}
				</h4>
				<div id="descrip">
					<img class="img" src="{{ asset('asset/picture/program-kami/'.$list->picture) }}">
					{!! $list->content !!}
				</div>
				<div class="clearfix"></div>
			</div>
			@endforeach
		</div>
	</div>

@endsection

@section('include_js')
	
@endsection
