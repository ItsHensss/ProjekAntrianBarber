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
			<!-- section begin -->
			<section id="subheader" class="jarallax">
				<img src="images/background/6.jpg" class="jarallax-img" alt="">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 offset-lg-3 text-center">
							<h1>Booking</h1>
							<div class="de-separator"></div>
						</div>
					</div>
				</div>
				<div class="de-gradient-edge-bottom"></div>
			</section>
			<!-- section close -->

			<section id="section-form" class="no-top">
				<div class="container">
					<div class="row">

						<div class="col-md-10 offset-md-1">
							<form name="contactForm" id='contact_form' class="form-border" method="post">
								<div id="step-1" class="row">
									<h3 class="s2">Choose Services</h3>

									<div class="row">
										@foreach ($fotokategoris as $kategori)
											<div class="col-xl-3 col-lg-6">
												<div class="sc-group">
													<h5>{{ $kategori->judul }}</h5>
													@if ($kategori->produks->count())
														@foreach ($kategori->produks as $produk)
															<div class="form-group">
																<input type="checkbox" name="services[]" id="produk_{{ $produk->id }}" value="{{ $produk->id }}">
																<label for="produk_{{ $produk->id }}">{{ $produk->judul }}</label>
															</div>
														@endforeach
													@else
														<p class="text-muted">Belum ada produk.</p>
													@endif
												</div>
											</div>
										@endforeach
									</div>

									<div class="spacer-single"></div>

									<!-- step 2 -->

									<div class="row">
										<div class="col-lg-6 mb-sm-30">
											<h3 class="s2">Choose Staff</h3>

											<div class="de_form de_radio">
												@foreach ($employees as $index => $employee)
													<div class="radio-img">
														<input id="radio-employee-{{ $employee->id }}" name="Staff" type="radio" value="{{ $employee->id }}"
															@if ($index === 0) checked="checked" @endif>
														<label for="radio-employee-{{ $employee->id }}">
															<img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->full_name }}">
															{{ $employee->full_name }}
														</label>
													</div>
												@endforeach
											</div>
										</div>

										<div class="col-lg-6">
											<h3 class="s2">Select Date</h3>
											<input type="date" name="date" id="date" class="form-control" min="1997-01-01" required />

										</div>
									</div>

									<div class="spacer-single"></div>

									<div class="row">
										<h3 class="s2">Your details</h3>

										<div class="col-lg-6">
											<div id='name_error' class='error'>Please enter your name.</div>
											<div class="mb25">
												<input type='text' name='Name' id='name' class="form-control" placeholder="Your Name" required>
											</div>

											<div id='email_error' class='error'>Please enter your valid E-mail ID.</div>
											<div class="mb25">
												<input type='email' name='Email' id='email' class="form-control" placeholder="Your Email" required>
											</div>

											<div id='phone_error' class='error'>Please enter your phone number.</div>
											<div class="mb25">
												<input type='text' name='phone' id='phone' class="form-control" placeholder="Your Phone" required>
											</div>
										</div>
										<div class="col-lg-6">
											<div id='message_error' class='error'>Please enter your message.</div>
											<div>
												<textarea name='message' id='message' class="form-control" placeholder="Your Message"></textarea>
											</div>
										</div>

										<div class="col-lg-12 text-center">
											<div class="g-recaptcha" data-sitekey="6LdW03QgAAAAAJko8aINFd1eJUdHlpvT4vNKakj6" align="center"></div>
											<p id='submit' class="mt20">
												<input type='submit' id='send_message' value='Submit Form' class="btn-main">
											</p>
										</div>
									</div>

								</div>

							</form>

							<div id="success_message" class='success'>
								Your message has been sent successfully. Refresh this page if you want to send more messages.
							</div>
							<div id="error_message" class='error'>
								Sorry there was an error sending your form.
							</div>

						</div>

					</div>
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
						Copyright 2025 - Deminebarbershop
					</div>
				</div>
			</div>
		</footer>
		<!-- footer close -->
	</div>

	@include('script')

	<script src='../../../www.google.com/recaptcha/api.js' async defer></script>
	<script src="form.js"></script>

	<script type="text/javascript">
		jQuery(function($) {
			$('.g-recaptcha').attr('data-theme', 'dark');
		});
	</script>

</body>

<!-- Mirrored from madebydesignesia.com/themes/blaxcut/book.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 May 2025 12:21:12 GMT -->

</html>
