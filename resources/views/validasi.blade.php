<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Validasi</title>
	<!-- SweetAlert2 CDN -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
	<div class="container py-5">
		<h3>Validasi Antrian</h3>

		<div class="card mt-4">
			<div class="card-body">
				<p><strong>Nomor Antrian:</strong> {{ $queue->nomor_antrian }}</p>
				<p><strong>Nama Pelanggan:</strong> {{ $queue->customer->nama ?? '-' }}</p>
				<p><strong>Produk:</strong> {{ $produk->judul ?? '-' }}</p>
				<p><strong>Status:</strong> {{ ucfirst($queue->status) }}</p>
				<p><strong>Sudah divalidasi?</strong> {{ $queue->is_validated ? 'Ya' : 'Belum' }}</p>

				@auth
					@if ($queue->status != 'selesai')
						<form action="{{ route('validasi.antrian.post', $queue->id) }}" method="POST">
							@csrf
							<button type="submit" class="btn btn-success mt-3">Validasi Sekarang</button>
						</form>
					@else
						<div class="alert alert-info mt-3">
							Antrian sudah divalidasi.
						</div>
					@endif
				@else
					<div class="alert alert-warning mt-3">
						Silakan login sebagai chapster untuk memvalidasi antrian.
						<br>
						<a href="/admin" class="btn btn-primary mt-2">Login Sebagai Chapster</a>
					</div>
				@endauth
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
