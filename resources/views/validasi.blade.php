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
	<div class="flex min-h-screen items-center justify-center bg-gray-100 py-8">
		<div class="mx-2 w-full max-w-md rounded-lg bg-white p-6 shadow-md sm:p-8">
			<h3 class="mb-6 text-center text-2xl font-semibold text-gray-800">Validasi Antrian</h3>

			<div class="space-y-4">
				<div class="flex flex-col sm:flex-row sm:justify-between">
					<span class="font-medium text-gray-600">Nomor Antrian:</span>
					<span class="text-gray-900">{{ $queue->nomor_antrian }}</span>
				</div>
				<div class="flex flex-col sm:flex-row sm:justify-between">
					<span class="font-medium text-gray-600">Nama Pelanggan:</span>
					<span class="text-gray-900">{{ $queue->customer->nama ?? '-' }}</span>
				</div>
				<div class="flex flex-col sm:flex-row sm:justify-between">
					<span class="font-medium text-gray-600">Produk:</span>
					<span class="text-gray-900">{{ $produk->judul ?? '-' }}</span>
				</div>
				<div class="flex flex-col sm:flex-row sm:justify-between">
					<span class="font-medium text-gray-600">Status:</span>
					<span class="text-gray-900">{{ ucfirst($queue->status) }}</span>
				</div>
				<div class="flex flex-col sm:flex-row sm:justify-between">
					<span class="font-medium text-gray-600">Sudah divalidasi?</span>
					<span class="text-gray-900">{{ $queue->is_validated ? 'Ya' : 'Belum' }}</span>
				</div>
			</div>

			@auth
				@if ($queue->status != 'selesai')
					<form action="{{ route('validasi.antrian.post', $queue->id) }}" method="POST" class="mt-8">
						@csrf
						<button type="submit" class="w-full rounded bg-green-500 py-2 font-semibold text-white transition hover:bg-green-600">
							Validasi Sekarang
						</button>
					</form>
				@else
					<div class="mt-8 rounded border border-blue-300 bg-blue-100 px-4 py-3 text-center text-blue-800">
						Antrian sudah divalidasi.
					</div>
				@endif
			@else
				<div class="mt-8 rounded border border-yellow-300 bg-yellow-100 px-4 py-3 text-center text-yellow-800">
					Silakan login sebagai chapster untuk memvalidasi antrian.
					<br>
					<a href="/admin" class="mt-3 inline-block rounded bg-blue-500 px-4 py-2 font-semibold text-white transition hover:bg-blue-600">
						Login Sebagai Chapster
					</a>
				</div>
			@endauth
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
