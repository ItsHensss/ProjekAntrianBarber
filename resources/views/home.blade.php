<!DOCTYPE html>
<html lang="zxx">

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
			<section id="de-carousel" class="no-top no-bottom carousel slide text-light carousel-fade" data-mdb-ride="carousel">
				<!-- Inner -->
				<div class="carousel-inner">
					<!-- Single item -->
					<div class="carousel-item active jarallax">
						<img src="images/background/7.jpg" class="jarallax-img" alt="">
						<div class="d-content z1000 relative">
							<div class="wm wm-carousel mt-30" data-jarallax-element="-50">
								<div class="wow fadeInRight">Demine <span class="t2">barbershop</span></div>
							</div>
							<div class="top-center">
								<div class="wow fadeInRight">
									<h1 class="id-color">Demine Barbers</h1>
								</div>
							</div>
							<div class="v-center">
								<div class="container">
									<div class="row align-items-center">
										<div class="col-lg-6 offset-lg-3 d-flex">
											<img src="images/misc/man.png" class="wow fadeInLeft" data-wow-delay=".3s" data-wow-duration="1.5s" alt="">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="de-gradient-edge-bottom"></div>
					</div>
					<!-- Single item -->

				</div>
				<!-- Inner -->

				<!-- Controls -->
				<a class="carousel-control-prev" href="#de-carousel" role="button" data-mdb-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#de-carousel" role="button" data-mdb-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</section>

			<section aria-label="section" class="no-top no-bottom">

				<div class="container">
					<div class="row">
						<div class="col-lg-12" data-jarallax-element="-50">
							<p class="lead big wow fadeInUp">
								Didirikan dengan semangat tinggi terhadap seni barber, kami sangat menjunjung
								profesionalisme dan dedikasi dalam memberikan layanan terbaik.
								Sejak Anda melangkah masuk, Anda akan disambut dengan keramahan dan suasana hangat yang
								membuat Anda merasa nyaman seperti di rumah sendiri.
							</p>
						</div>
					</div>
				</div>
			</section>

			<section id="section-trending" class="pt80">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-8 offset-lg-2 text-center">
							<h2 class="wow fadeIn">Gallery Styles</h2>
							<div class="de-separator"></div>
							<div class="spacer-single"></div>
						</div>
					</div>
					<!-- Modal -->
					<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="photoModalLabel">Photo Details</h5>
									<!-- Menggunakan kelas btn-close-white untuk warna putih -->
									<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<img id="modalImage" class="img-fluid" alt="Selected photo">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12" data-jarallax-element="-20">
							<div class="d-carousel wow fadeInRight">
								<div id="item-carousel-big" class="owl-carousel no-hide owl-center" data-wow-delay="1s">
									@foreach ($fotoPotongans as $foto)
										<div class="c-item">
											<a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="setModalImage('{{ asset('storage/' . $foto->image) }}')">
												<span class="c-item_info">
													<span class="c-item_title">{{ $foto->judul }}</span>
													<span class="c-item_wm">#{{ $loop->iteration }}</span>
												</span>
												<div class="c-item_wrap">
													<img src="{{ asset('storage/' . $foto->image) }}" class="lazy img-fluid" alt="{{ $foto->judul }}">
												</div>
											</a>
										</div>
									@endforeach
								</div>
								<div class="d-arrow-left mod-a"><i class="fa fa-angle-left"></i></div>
								<div class="d-arrow-right mod-a"><i class="fa fa-angle-right"></i></div>
							</div>
							<div class="spacer-double"></div>
						</div>
					</div>
				</div>
			</section>

			<section class="no-top jarallax">
				<div class="de-gradient-edge-top"></div>
				<img src="images/background/1.jpg" class="jarallax-img" alt="">
				<div class="z1000 container relative">
					<div class="row align-items-center">
						<div class="col-lg-6" data-jarallax-element="-30">
							<img src="images/misc/man-2.png" class="img-fluid wow fadeInRight" alt="">
						</div>
						<div class="col-lg-6" data-jarallax-element="-60">
							<h2 class="wow fadeInRight" data-wow-delay=".3s">Kami Hadir untuk Meningkatkan <span class="id-color">Kepercayaan Diri</span> Anda Lewat
								Gaya
								Terbaik</h2>
							<p class="wow fadeInRight" data-wow-delay=".4s">Kami berkomitmen memberikan layanan
								grooming terbaik dengan perpaduan teknik klasik dan tren
								modern. Rasakan suasana hangat dan profesional, serta tim barber berpengalaman yang siap
								membantu Anda tampil percaya diri dan berkelas.</p>
							<a href="{{ url('customer') }}" class="btn-main wow fadeInRight" data-wow-delay=".5s" style="margin-left: 10px;">
								Booking Sekarang
							</a>
						</div>
					</div>
				</div>
				<div class="de-gradient-edge-bottom"></div>
			</section>

			{{-- <section aria-label="section" class="no-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<h2 class="wow fadeIn">Kategori</h2>
							<div class="de-separator"></div>
						</div>
						@foreach ($fotokategoris as $kategori)
							<div class="col-lg-3 mb-4 text-center" data-jarallax-element="-20">
								<div class="de-box-a">
									<div class="d-image">
										<img src="{{ asset('storage/' . $kategori->image) }}" alt="{{ $kategori->judul }}">
									</div>
									<div class="d-deco-1"></div>
									<div class="d-deco-2"></div>
								</div>
								<div class="spacer-20"></div>
								<h4>{{ $kategori->judul }}</h4>
							</div>
						@endforeach
					</div>
					<div class="spacer-single"></div>
				</div>
			</section> --}}

			<section class="jarallax no-top">
				<div class="de-gradient-edge-top"></div>
				<img src="images/background/1.jpg" class="jarallax-img" alt="">
				<div class="z1000 container relative">
					<div class="row gx-5">
						<div class="col-lg-6 text-center" data-jarallax-element="-50">
							<div class="d-sch-table">
								<h2 class="wow fadeIn">We're Open</h2>
								<div class="de-separator"></div>
								@foreach ($jamOperational as $jam)
									<div class="d-col">
										<div class="d-title">{{ $jam->day }}</div>
										@if ($jam->is_open)
											<div class="d-content id-color">
												{{ \Carbon\Carbon::createFromFormat('H:i:s', $jam->open_time)->format('g:i A') }}
												-
												{{ \Carbon\Carbon::createFromFormat('H:i:s', $jam->close_time)->format('g:i A') }}
											</div>
										@else
											<div class="d-content text-danger">Closed</div>
										@endif
									</div>
								@endforeach
								<div class="d-deco"></div>
							</div>
						</div>

						<div class="col-lg-6 text-center" data-jarallax-element="-100">
							<div class="d-sch-table">
								<h2 class="wow fadeIn">Location</h2>
								<div class="de-separator"></div>
								@foreach ($lokasiCabang as $lokasi)
									<div class="d-col mb-3">
										<div class="d-title text-truncate" style="max-width: 100%; white-space: normal; word-break: break-word;">
											{{ $lokasi->nama_cabang }}</div>
										<div class="d-content id-color" style="max-width: 100%; white-space: normal; word-break: break-word;">
											{{ $lokasi->alamat }},
											{{ $lokasi->kota }}</div>
										<div class="d-content id-color" style="max-width: 100%; white-space: normal; word-break: break-word;">Telp:
											{{ $lokasi->telepon }}</div>
										<div class="d-content id-color" style="max-width: 100%; white-space: normal; word-break: break-word;">
											Email: {{ $lokasi->email }}</div>
									</div>
								@endforeach
								<div class="d-deco"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="de-gradient-edge-bottom"></div>
			</section>

			@include('textrun')

		</div>
		<!-- content close -->
		<a href="#" id="back-to-top"></a>
		<!-- footer begin -->
		@include('footer')
		<!-- footer close -->
	</div>
	@include('script')

</body>
<script>
	function setModalImage(imageUrl) {
		// Set image in the modal
		document.getElementById('modalImage').src = imageUrl;
	}
</script>

<!-- Mirrored from madebydesignesia.com/themes/blaxcut/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 12:21:00 GMT -->

</html>
