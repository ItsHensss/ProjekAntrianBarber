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
							<li><a class="menu-item" href="{{ route('services') }}">Services</a>
								<ul>
									<li><a class="menu-item" href="{{ route('services') }}">All Services</a></li>
								</ul>
							</li>
							<li><a class="menu-item" href="{{ route('about') }}">About</a>
								<ul>
									<li><a class="menu-item" href="{{ route('about') }}">About Us</a></li>
									<li><a class="menu-item" href="{{ route('team') }}">Our Team</a></li>
								</ul>
							</li>
							<li><a class="menu-item" href="{{ route('book') }}">Book Now</a></li>
							<li><a class="menu-item" href="#">Extras</a>
								<ul>
									<li><a class="menu-item" href="{{ route('contact') }}">Contact</a></li>
									<li><a class="menu-item" href="{{ route('gallery') }}">Gallery</a></li>
									<li><a class="menu-item" href="{{ route('pricing') }}">Pricing</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="de-flex-col">
						<div class="menu_side_area">
							<a href="{{ route('book') }}" class="btn-main">Book Now</a>
							<span id="menu-btn"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
