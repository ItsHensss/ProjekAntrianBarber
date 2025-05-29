<header class="transparent">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="de-flex sm-pt10">
					<div class="de-flex-col">
						<div class="de-flex-col">
							<!-- logo begin -->
							<div id="logo">
								<a href="{{ route('services') }}">
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
							<li><a class="menu-item" href="{{ route('contact') }}">Kontak</a></li>
							<li><a class="menu-item" href="{{ route('gallery') }}">Gallery</a></li>
						</ul>
					</div>
					<div class="de-flex-col">
						<div class="menu_side_area">
							<a href="https://wa.me/6285942966128" class="btn-main" target="_blank" rel="noopener">
								Kontak Kami
							</a>
							<a href="{{ url('customer') }}" class="btn-main" style="margin-left: 10px;">
								Booking
							</a>
							<span id="menu-btn"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
