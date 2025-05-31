<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from madebydesignesia.com/themes/blaxcut/services.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 12:21:09 GMT -->

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
							<h1>Produk Kami</h1>
							<div class="de-separator"></div>
						</div>
					</div>
				</div>
				<div class="de-gradient-edge-bottom"></div>
			</section>

			<section aria-label="section" class="no-top no-bottom">

				<div class="container">
					<div class="row">
						<div class="col-lg-12" data-jarallax-element="-20">
							<p class="lead big wow fadeInUp">
								Yuk, rasain vibes kekinian di tempat kami! Gabungan nuansa vintage & modern bikin suasana makin cozy buat kamu yang mau tampil kece. Dari
								masuk sampai pulang, detail pelayanan kami siap bikin kamu makin percaya diri. #GlowUpBarengKita
							</p>
						</div>
					</div>
				</div>
			</section>

			<section id="section-pricing" aria-label="section">
				<div class="container">
					<div class="row g-5" id="gallery">
						<div class="col-lg-12 item">
							<div class="sc-wrap">
								<h3>Produk Kami</h3>
								<div class="def-list-dots">
									@forelse ($produk as $item)
										<dl>
											<dt>
												<span>{{ $item->judul }}</span>
											</dt>
											<dd>Rp{{ number_format($item->harga, 0, ',', '.') }}</dd>
										</dl>
									@empty
										<p class="text-muted">Belum ada produk.</p>
									@endforelse
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

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
										<div class="d-title text-truncate" style="max-width: 100%; white-space: normal; word-break: break-word;">{{ $lokasi->nama_cabang }}</div>
										<div class="d-content id-color" style="max-width: 100%; white-space: normal; word-break: break-word;">{{ $lokasi->alamat }},
											{{ $lokasi->kota }}</div>
										<div class="d-content id-color" style="max-width: 100%; white-space: normal; word-break: break-word;">Telp: {{ $lokasi->telepon }}</div>
										<div class="d-content id-color" style="max-width: 100%; white-space: normal; word-break: break-word;">Email: {{ $lokasi->email }}</div>
									</div>
								@endforeach
								<div class="d-deco"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="de-gradient-edge-bottom"></div>
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

<!-- Mirrored from madebydesignesia.com/themes/blaxcut/services.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 12:21:09 GMT -->

</html>
