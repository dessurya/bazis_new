@extends('main.layout.basic')

@section('title_front')Agenda | @endsection

@section('title_back') @endsection

@section('include_css')
<link rel="stylesheet" href="{{ URL::to('/') }}/public/plugin/owl-carousel/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="{{ URL::to('/') }}/public/plugin/owl-carousel/owl-carousel/owl.theme.css">
<link rel="stylesheet" href="{{ URL::to('/') }}/public/plugin/owl-carousel/owl-carousel/owl.transitions.css">
@endsection

@section('include_less')
<link rel="stylesheet/less" href="{{ URL::to('/') }}/public/less/agenda.less">
@endsection

@section('body')
<div class="banner">
	<div style="background-image:url('{{ URL::to('/') }}/public/image/default/banner.jpg');">

	</div>
</div>

<div  id="BdK" class="opening" style="background-color: rgba(185,185,185,.4);">
	<div class="container text-center">
		<h1>AGENDA BAZIS KOTA ADMINISTRASI JAKARTA UTARA</h1>
		<p>
			Ulasan mengenai kegiatan-kegiatan yang akan maupun yang telah diselenggarakan oleh Bazis Kota Administrasi Jakarta Utara, kegiatan-kegiatan yang dilaksanakan tersebut merupakan 5 program kegiatan utama Bazis Kota Adminstrasi Jakarta Utara, yaitu Jakarta Bertaqwa, Jakarta Cerdas, Jakarta Mandiri, Jakarta Peduli dan Jakarta Sadar Zakat. Melalui Portal Kegiatan ini kami ingin menyampaikan kepada para Muzaki yang telah mempercayakan Zakat, Infaq dan Sodaqohnya kepada kami bahwa kami telah menyampaikan amanah yang mereka titipkan kepada kami melalui kegiatan-kegiatan yang bermanfaat untuk saudara-saudara kita yang membutuhkan.
		</p>
	</div>
</div>

<div class="news">
	<div class="container">
		<h2>Berita dan Kegiatan</h2>
		<div class="owl-slider owl-carousel owl-theme">
			<div class="item">
				<div class="row">
					@php
						$count_news = 1;
						$limit_news = 40;
						$item_max = 6;
					@endphp
					@for($loop_news=1; $loop_news<=$limit_news; $loop_news++)
					<div class="col-md-6 news-item">
						<div class="border" style="background-color: rgba(185,185,185,.4);">
							<div class="row">
								<div class="col-md-4">
									<div class="img" style="background-image: url('{{ URL::to('/') }}/public/image/default/foto_wahyu.png');">
									</div>
								</div>
								<div class="col-md-8">
									<label>Title</label>
									<div class="text-justify">
										Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak... <a href="">selengkapnya</a>
									</div>
									<table>
										<tr>
											<th><i class="fa fa-user" aria-hidden="true"></i></th>
											<th>:</th>
											<th>Admin Bazis Jakarta Utara</th>
										</tr>
										<tr>
											<th><i class="fa fa-calendar" aria-hidden="true"></i></th>
											<th>:</th>
											<th>13, Februari 2017</th>
										</tr>
									</table>

								</div>
							</div>
								
									
						</div>
					</div>
					@if($count_news%$item_max == 0)
						@if($count_news == $limit_news)
				</div>
			</div>
						@else
				</div>
			</div>
			<div class="item">
				<div class="row">
						@endif
					@elseif($count_news == $limit_news)
				</div>
			</div>
					@endif
					@php ($count_news++)
					@endfor
		</div>
		<div class="text-center">
			<label>
				<a href="{!! route('main.agenda.agenda-all') !!}">
					Lihat Berita dan kegitan Lainnya
				</a>
			</label>
		</div>
		<hr>
	</div>
</div>
@endsection

@section('include_js')
<script src="{{ URL::to('/') }}/public/plugin/owl-carousel/owl-carousel/owl.carousel.min.js "></script>
<script type="text/javascript">

$(document).ready(function() {
    //Init the carousel
    $(".owl-slider").owlCarousel({
        navigation :false,
        slideSpeed : 5000,
        paginationSpeed : 5000,
        singleItem : true,
        items : 1,
        pagination : true,
        mouseDrag: false,
        touchDrag:false,
        autoPlay: 60000,
        transitionStyle : "backSlide"
    });
});

$(document).ready(function() {
	// animate scroll to up if clik paginate carousel
    $(".owl-page").html("<a href='#BdK'><span class=''></span></a>");
});

</script>
@endsection
