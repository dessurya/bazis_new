@extends('frontend._layout.basic')

@section('title')
	<title>Bazis Kota Administrasi Jakarta Utara</title>
@endsection

@section('meta')
	<meta name="title" content="">
	<meta name="description" content="">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/beranda.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/owl-carousel/owl.carousel.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/owl-carousel/owl.theme.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/owl-carousel/owl.transitions.css') }}">
@endsection

@section('body')
	<div id="banner" class="section">
		@foreach($Banner as $list)
		<div class="item" style="background-image: url('{{ asset('asset/picture/banner/'.$list->picture) }}');"></div>
		@endforeach
	</div>
	<div class="after-section odd"></div>

	<div id="program" class="section odd">
		<div class="wrapper medium">
			<h2 class="text-center">Program Kami</h2>
			<div id="content">
				@foreach($ProgramBazis as $list)
				<div class="card">
					<h4 class="text-left" title="{{ $list->title }}">{{ $list->title }}</h4>
					<div id="descrip">
						{!! Str::words(strip_tags($list->content), 15, '...') !!}
					</div>
					<br>
					<a class="btn-link" href="{{ route('frontend.sk.program').'#'.str_slug($list->title) }}">Lihat</a>
					<br><br>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="after-section even"></div>

	<div id="testimoni" class="section even">
		<div class="wrapper medium">
			@foreach($Testimoni as $list)
			<div class="box">
				<div class="float">
					<h3>{{ $list->title }}</h3>
					{!! $list->content !!}
				</div>
				<div class="float">
					<div class="text-center">
						<img title="{{ $list->title }}" src="{{ asset('asset/picture/testimoni/'.$list->picture) }}">
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			@endforeach
		</div>
	</div>
	<div class="after-section odd"></div>

	<div id="content" class="section odd">
		<div class="wrapper medium">
			<div id="berita" class="section-content">
				<h2 class="text-center">Kabar Berita Bazis</h2>
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
			<div id="galeri" class="section-content">
				<h2 class="text-center">Galeri Bazis</h2>
				@foreach($AlbumFoto as $list)
				<div class="card">
					<div id="border">
						<div id="img" title="{{ $list->title }}" style="background-image: url('{{ asset('asset/picture/album-foto/'.$list->picture) }}');"></div>
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
				@foreach($YoutubeEmbed as $list)
				@php
					$url 			= $list->url_youtube;
					$step1			= explode('v=', $url);
					$step2 			= explode('&',$step1[1]);
					$vedio_id 		= $step2[0];
					
					$thumbnail 		= 'http://img.youtube.com/vi/'.$vedio_id.'/0.jpg';
				@endphp
				<div class="card">
					<div id="border">
						<div id="img" title="{{ $list->title }}" style="background-image: url('{{ $thumbnail }}');"></div>
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

	@if($Iklan != null)
	<div id="advertisement">
		<div id="adv-wrapper">
			<div id="adv-content">
				<button id="close" class="btn-link close-form-class">
					Close <b>10</b> Second
				</button>
				<br>
				<img title="{{ $Iklan->title }}" alt="{{ $Iklan->title }}" src="{{ asset('asset/picture/iklan/'.$Iklan->picture) }}">
			</div>
		</div>
	</div>
	@endif

@endsection

@section('include_js')
	<script type="text/javascript" src="{{ asset('frontend/vendor/owl-carousel/owl.carousel.min.js') }}"></script>
	<script type="text/javascript">
		$("#banner").owlCarousel({
			navigation : false,
			items: 1,
			singleItem:true,
			pagination:false,
			autoPlay: 3000,
		    stopOnHover:false
		});
	</script>

	<script type="text/javascript">
		$(function(){
			window.setInterval(function() {
		    	var timeCounter = $("#advertisement button#close b").html();
		        var updateTime = eval(timeCounter)- eval(1);
		        $("#advertisement button#close").html("Close <b>"+updateTime+"</b> Second");
		        if(updateTime == 0){
		        	$("#advertisement").fadeTo(700, 0).slideUp(700, function(){
						$(this).remove();
					});
		        }
			}, 1000);

			$('#advertisement button#close').click(function() {
		    	$("#advertisement").fadeTo(700, 0).slideUp(700, function(){
					$(this).remove();
				});
		    });
		});
	</script>
@endsection
