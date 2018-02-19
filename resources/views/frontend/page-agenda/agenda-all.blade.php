@extends('main.layout.basic')

@section('title_front')Agenda | @endsection

@section('title_back') | Indeks @endsection

@section('include_css')

@endsection

@section('include_less')
<link rel="stylesheet/less" href="{{ URL::to('/') }}/public/less/agenda-all.less">
@endsection

@section('body')
<div class="banner">
	<div style="background-image:url('{{ URL::to('/') }}/public/image/default/banner.jpg');">

	</div>
</div>

@php
	$arr_month = [
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mai",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember",
		"asdas"
	];
@endphp

<div class="index-of-agenda">
	<div class="container">
		<div class="row">
			<div class="col-md-3 index">
				<h4>Indeks Pencarian</h4>
				<div class="panel-group" id="accordion-year">
					@php
						$from_year = 2017;
						$collapse_year = "collapse-year-";
					@endphp
					@for($loop_accordion_year=0; $loop_accordion_year<=4; $loop_accordion_year++)
					@php
						$collapse_year = $collapse_year.($from_year - $loop_accordion_year);
					@endphp
					<div class="panel">
						<div class="panel-heading title-year" data-toggle="collapse" data-parent="#accordion-year" href="#{!!$collapse_year!!}">
								<label>
									{!! $from_year - $loop_accordion_year !!}
								</label>
						</div>
						<div id="{!!$collapse_year!!}" class="panel-collapse collapse">
							<div class="panel-group" id="accordion-month-{!!($from_year - $loop_accordion_year)!!}">
								@php($month = 0)
								@for($loop_month=0; $loop_month<=11; $loop_month++)
								<div class="panel">
									<div 
										class="panel-heading title-month" 
										data-toggle="collapse" 
										data-parent="#accordion-month-{!!($from_year - $loop_accordion_year)!!}" 
										href="#{!!$arr_month[$month].($from_year - $loop_accordion_year)!!}"
									>
										<label>
											{!! $arr_month[$month] !!}
										</label>
									</div>
								</div>
								<div 
									id="{!!$arr_month[$month].($from_year - $loop_accordion_year) !!}" 
									class="panel-collapse collapse"
								>
									<ul class="agenda">
										@for($i=0; $i<=3; $i++)
										<li>
											<a href="">Judul Berita dan Kegiatan</a>
										</li>
										@endfor
									</ul>
								</div>
								@php($month++)
								@endfor
							</div>
						</div>
					</div>
					@endfor
				</div>
			</div>
			<div class="col-md-9 time-line">
				<h4>Time Line</h4>
				@for($loop_item=0; $loop_item<=4; $loop_item++)
				<div class="news">
					<div class="head row">
						<div class="col-md-1">
							<div class="img" style="background-image: url('{{ URL::to('/') }}/public/image/default/foto_wahyu.png');">
							</div>
						</div>
						<div class="col-md-11 identification">
								<label>Name Publish</label>
								<i class="news-i-action fa fa-minus-square-o" 
									aria-hidden="true" 
									data-toggle="tooltip" 
									data-placement="top" 
									title="Kecilkan/Rentangkan"></i>
								<hr>
								<label>Diterbitkan Pada : 3, Januari 2017</label>	
						</div>
					</div>
					<div class="body">
						<img class="img" src="{{ URL::to('/') }}/public/image/default/logo_bazisjakut.png">
						<div class="description">
							<label>Judul {!! $loop_item !!}</label>
							<label class="action">
								<a href="">
									Baca
								</a>
							</label>
							<label class="action">
								<a href="">
									Bagikan
								</a>
							</label>
							<hr>
							<label class="text-justify">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum ...
							</label>
						</div>
					</div>
				</div>
				@endfor
			</div>
		</div>
	</div>
	<hr>
</div>

<div style="height: 100px">
	
</div>
@endsection

@section('include_js')
<script type="text/javascript">
	$(".panel-heading").css("cursor", "pointer");
	
	$(".news-i-action").click(function(){
		$(this).parent().parent().next().slideToggle();
	});
</script>
@endsection
