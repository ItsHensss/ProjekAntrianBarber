<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Validasi</title>
	<!-- SweetAlert2 CDN -->
	<!-- Bootstrap CSS CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons CDN (optional for icon on button) -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

	<style>
		@media (max-width: 576px) {
			.card-body {
				padding: 1rem !important;
			}

			.card {
				max-width: 98vw !important;
			}
		}
	</style>
	<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light container py-5">
		<div class="w-100 mx-2" style="max-width: 420px;">
			<div class="card border-dark border shadow-sm" style="border-style: dashed;">
				<div class="card-body px-3 py-4 text-center" style="font-family: 'Courier New', monospace;">
					<img src="{{ asset('images/logo-besar.png') }}" alt="Logo" class="mb-2" style="width:50px; height:auto;">

					<div class="fw-bold mb-2" style="font-size: 1.1rem;">Demine Barbers</div>
					<div class="mb-3" style="font-size: 0.95rem;">{{ $cabang->name ?? 'Cabang' }}</div>

					<hr class="dashed my-2">

					<div class="fw-bold mb-2" style="font-size: 1rem;">Nomor Antrian</div>
					<div class="mb-3" style="font-size: 2rem; font-weight: bold;">{{ $queue->nomor_antrian }}</div>

					<div class="mb-1" style="font-size: 0.95rem;">
						{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
					</div>
					<div class="mb-3" style="font-size: 0.85rem; color: #666;">
						{{ $cabang->lokasi->first()->alamat ?? '-' }}
					</div>

					<hr class="dashed my-2">

					<div class="text-start" style="font-size: 0.95rem;">
						<strong>Pelanggan:</strong> {{ $queue->customer->nama ?? '-' }} <br>
						<strong>Produk:</strong> {{ $produk->judul ?? '-' }} <br>
						<strong>Status:</strong> {{ ucfirst($queue->status) }} <br>
						<strong>Validasi:</strong> {{ $queue->is_validated ? 'Ya' : 'Belum' }} <br>
						<strong>Harga:</strong> Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}
					</div>

					@auth
						@if ($queue->status != 'selesai')
							<form action="{{ route('validasi.antrian.post', $queue->id) }}" method="POST" class="mt-4">
								@csrf
								<button type="submit" class="btn btn-dark w-100 fw-semibold rounded-pill py-2" style="font-size:1rem; letter-spacing:0.5px;">
									<i class="bi bi-check-circle me-2"></i>
									Validasi Sekarang
								</button>
							</form>
						@else
							<div class="alert alert-success mt-3" role="alert">
								Antrian sudah divalidasi.
							</div>
						@endif
					@else
						<div class="alert alert-warning mt-3 text-center" role="alert">
							Silakan login sebagai chapster untuk memvalidasi antrian.<br>
							<a href="/admin" class="btn btn-primary fw-semibold rounded-pill mt-2 px-4 py-2" style="font-size:0.95rem;">
								Login Sebagai Chapster
							</a>
						</div>
					@endauth
				</div>
			</div>
		</div>
	</div>

	@if (session('success'))
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Berhasil',
				text: '{{ session('success') }}',
				confirmButtonColor: '#3085d6',
			});
		</script>
		@if (session('back_url'))
			<div class="d-flex justify-content-center mt-3">
				<a href="{{ session('back_url') }}" class="btn btn-outline-primary rounded-pill px-4">
					<i class="bi bi-arrow-left"></i> Kembali ke Antrian
				</a>
			</div>
		@endif
	@endif

	@if (session('error'))
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Gagal',
				text: '{{ session('error') }}',
				confirmButtonColor: '#d33',
			});
		</script>
	@endif

</body>

</html>
