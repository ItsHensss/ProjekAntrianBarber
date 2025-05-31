<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from madebydesignesia.com/themes/blaxcut/gallery.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 12:21:14 GMT -->

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
				<div class="container">
					<div class="row">
						<div class="col-lg-6 offset-lg-3 text-center">
							<h1>Gallery</h1>
							<div class="de-separator"></div>
						</div>
					</div>
				</div>
				<div class="de-gradient-edge-bottom"></div>
			</section>

			<section class="no-top no-bottom" aria-label="section">
				<div class="container-fluid">
					@if ($foto_interior->isEmpty())
						<div class="row justify-content-center">
							<div class="col-md-6 text-center">
								<div class="alert alert-warning mt-5">
									Belum ada data foto interior.
								</div>
							</div>
						</div>
					@else
						<div id="gallery" class="row g-3">
							@foreach ($foto_interior as $index => $foto)
								@php
									// Variasi layout: besar di awal, lalu 2 kecil, lalu 1 besar, dst
									$layout = $index % 4 == 0 ? 'col-md-8' : 'col-md-4';
								@endphp
								<div class="{{ $layout }} item">
									<div class="de-image-hover rounded">
										<a href="{{ asset('storage/' . $foto->image) }}" class="image-popup">
											<span class="dih-title-wrap">
												<span class="dih-title">{{ $foto->judul ?? 'Foto Interior' }}</span>
											</span>
											<span class="dih-overlay"></span>
											<img src="{{ asset('storage/' . $foto->image) }}" class="lazy img-fluid" alt="{{ $foto->judul }}">
										</a>
										@if ($foto->deskripsi)
											<div class="small mt-2 px-2 text-white">
												{{ $foto->deskripsi }}
											</div>
										@endif
										@if ($foto->tenant)
											<div class="text-muted small px-2">
												<i class="fa fa-map-marker"></i> {{ $foto->tenant->nama ?? '' }}
											</div>
										@endif
									</div>
								</div>
							@endforeach
						</div>
					@endif
				</div>
			</section>

		</div>
		<!-- content close -->
		<a href="#" id="back-to-top"></a>
		<!-- footer begin -->
		@include('footer')
		<!-- footer close -->
	</div>
	@include('script')

</body>

<!-- Mirrored from madebydesignesia.com/themes/blaxcut/gallery.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 12:21:14 GMT -->

</html>
