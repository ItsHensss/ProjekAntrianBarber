<header class="transparent">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="de-flex sm-pt10">
					<div class="de-flex-col">
						<div class="de-flex-col">
							<!-- logo begin -->
							<div id="logo">
								<a href="{{ route('home') }}">
									<img class="logo-main" src="images/logo.png" alt="">
									<img class="logo-mobile" src="images/logo-mobile.png" alt="">
								</a>
							</div>
							<!-- logo close -->
						</div>
					</div>
					<div class="de-flex-col header-col-mid">
						<ul id="mainmenu">
							<li><a class="menu-item" href="{{ route('services') }}">Produk</a></li>
							<li><a class="menu-item" href="{{ route('about') }}">Tentang</a></li>
							<li><a class="menu-item" href="{{ route('gallery') }}">Gallery</a></li>
							<li class="menu-item-has-children">
								<a href="#">Antrian Cabang</a>
								<ul>
									@foreach ($cabang as $item)
										<li>
											<a href="{{ route('antrian.cabang', ['id' => $item->id]) }}">
												Antrian {{ $item->name }}
											</a>
										</li>
									@endforeach
								</ul>
							</li>
							<li><a class="menu-item">Lainnya</a>
								<ul>
									<li><a href="{{ url('admin') }}" target="_blank" style="margin-left: 10px;">
											Login Chapster
										</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="de-flex-col">
						<div class="menu_side_area">
							<a href="https://{{ $lokasiPertama->telepon }}" class="btn-main" target="_blank" rel="noopener">
								Kontak Kami
							</a>
							@if (Auth::check())
								<a href="{{ url('customer') }}" class="btn-main" style="margin-left: 10px;">
									Dashboard
								</a>
							@else
								<a href="{{ url('customer') }}" class="btn-main" style="margin-left: 10px;">
									Booking
								</a>
							@endif
							<span id="menu-btn"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
