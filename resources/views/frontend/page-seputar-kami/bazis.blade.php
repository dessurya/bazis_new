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
@endsection

@section('body')
	<div id="banner" class="section" style="background-image: url('{{ asset('asset/picture/halaman/'.$page->picture) }}');"></div>
	<div class="after-section odd"></div>

	<div class="content section odd">
		<div class="wrapper medium">
			<h2 class="text-center">{{ $page->title }}</h2>
			{!! $page->content !!}
		</div>
	</div>

@endsection

@section('include_js')
	
@endsection
