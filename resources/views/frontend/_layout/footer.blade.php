<div id="footer" class="section even">
	<div class="wrapper medium">
		<div class="bar">
			<img id="logo" src="{{ asset('asset/picture/data-bazis/'.$lgBazis->picture) }}">
			<div id="bank">
				<h4>Bermitra Bersama Kami</h4>
				@foreach($BankPenerimaZIS as $list)
				<img title="{{ $list->bank_nama }}" src="{{ asset('asset/picture/penerimaan-zis/bank/'.$list->bank_logo) }}">
				@endforeach
			</div>
		</div>
		<div class="bar text-right">
			<h3>
				<a href="">
					<label class="icon">Bertanya Pada Kami <i class="fas fa-comments"></i></label>
				</a>
			</h3>
			<h8>Hubungi Kami</h8>
			<p>{{$alamat->content}}</p>
			<p>
				<label class="icon" title="{{$telpon->title}}">
					<i class="fas fa-phone"></i> {{$telpon->content}}
				</label>
				<label class="icon" title="{{$fax->title}}">
					<i class="fas fa-tty"></i> {{$fax->content}}
				</label>
				<label class="icon" title="{{$email->title}}">
					<i class="fas fa-at"></i> {{$email->content}}
				</label>
			</p>
			<h8>Temukan Kami</h8>
			<p>
				@foreach($medsos as $list)
				<label title="{{ $list->title }}">
					<a href="{{ $list->content }}" target="_blank">
						<img src="{{ asset('asset/picture/media-sosial/'.$list->picture) }}">
					</a>
				</label>
				@endforeach
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="after-section text-center">
		<label>
			© Hak Cipta 2018 BAZIS KOTA ADMINISTRASI JAKARTA UTARA
		</label>
	</div>
</div>