<div id="navigasibar">
	<div id="lineSt">
		<div id class="wrapper large text-right">
			Badan Amil Zakat Infaq dan Shadaqah Kota Administrasi Jakarta Utara
		</div>
	</div>
	<div id="lineNd">
		<div class="wrapper large">
			<div class="bar">
				<div class="item {{ route::is('frontend.beranda') ? 'active' : '' }}">
					<a href="{{ route('frontend.beranda') }}">
						Beranda
					</a>
				</div>
				<div class="item {{ route::is('frontend.sk*') ? 'active' : '' }} dropdown">
					<a>
						Seputar Kami
					</a>
					<div class="dropdown-content">
						<div>
							<a href="{{ route('frontend.sk.bazis') }}">
								Bazis Jakarta Utara
							</a>
						</div>
						<div>
							<a href="{{ route('frontend.sk.program') }}">
								Program Kami
							</a>
						</div>
					</div>
				</div>
				<div class="item">
					<a href="{{ route('frontend.kb.index') }}">
						Kabar Berita
					</a>
				</div>
				<div class="item dropdown">
					<a>
						Galeri ZIS
					</a>
					<div class="dropdown-content">
						<div>
							<a href="">
								Album Foto
							</a>
						</div>
						<div>
							<a href="">
								Album Video
							</a>
						</div>
					</div>
				</div>
				<div class="item dropdown">
					<a>
						Laporan ZIS
					</a>
					<div class="dropdown-content">
						<div>
							<a href="">
								Pendayagunaan
							</a>
						</div>
						<div>
							<a href="">
								Pengumpulan ZIS
							</a>
						</div>
					</div>
				</div>
				<div class="item dropdown">
					<a>
						Penerimaan ZIS
					</a>
					<div class="dropdown-content">
						<div>
							<a href="">
								Membayar ZIS
							</a>
						</div>
						<div>
							<a href="">
								Riwayat Penerimaan ZIS
							</a>
						</div>
					</div>
				</div>
				<div class="item">
					<a href="">
						Bertanya Pada Kami
					</a>
				</div>
			</div>
		</div>
		<img id="logo" src="{{ asset('asset/picture/data-bazis/'.$lgBazis->picture) }}">
		<div id="burger-icon">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
</div>