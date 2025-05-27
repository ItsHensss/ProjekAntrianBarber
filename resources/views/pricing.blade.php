<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from madebydesignesia.com/themes/blaxcut/pricing.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 12:21:14 GMT -->

<head>
	@include('head')
</head>

<body class="dark-scheme">
	<div id="wrapper">

		<!-- page preloader begin -->
		<div id="de-loader"></div>
		<!-- page preloader close -->

		<!-- header begin -->
		@include('header')

		<!-- header close -->
		<!-- content begin -->
		<div class="no-bottom no-top" id="content">
			<div id="top"></div>

			<section id="subheader" class="jarallax">
				<img src="images/background/2.jpg" class="jarallax-img" alt="">
				<div class="de-gradient-edge-bottom"></div>
			</section>

			<section class="no-top no-bottom" aria-label="section">
				<div class="container">
					@foreach ($fotokategoris as $kategori)
						<div class="row mb-5">
							<div class="col-lg-8 offset-lg-2">
								<div class="d-sch-table">
									<h2 class="wow fadeIn text-center">{{ $kategori->judul }}</h2>
									<div class="de-separator"></div>
									<div class="sc-wrap">
										<div class="def-list-dots">
											@foreach ($kategori->produks as $produk)
												<dl>
													<dt>
														<span>{{ $produk->judul }}</span>
													</dt>
													<dd>Rp{{ number_format($produk->harga, 0, ',', '.') }}</dd>
												</dl>
											@endforeach
										</div>
									</div>
									<div class="d-deco"></div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</section>
		</div>
		<!-- content close -->
		<a href="#" id="back-to-top"></a>
		<!-- footer begin -->
		<footer>
			<div class="container">
				<div class="row g-4">

					<div class="col-lg-4 text-lg-start text-center">
						<div class="social-icons">
							<a href="#"><i class="fa fa-facebook fa-lg"></i></a>
							<a href="#"><i class="fa fa-twitter fa-lg"></i></a>
							<a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
							<a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
							<a href="#"><i class="fa fa-rss fa-lg"></i></a>
						</div>
					</div>
					<div class="col-lg-4 text-lg-center text-center">
						<img src="images/logo.png" class="" alt="">
					</div>
					<div class="col-lg-4 text-lg-end text-center">
						Copyright 2025 - Blaxcut by Designesia
					</div>
				</div>
			</div>
		</footer>
		<!-- footer close -->
	</div>
	@include('script')

</body>

<!-- Mirrored from madebydesignesia.com/themes/blaxcut/pricing.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 12:21:14 GMT -->

</html>
