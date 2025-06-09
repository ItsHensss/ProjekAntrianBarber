<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title>Print Antrian</title>
	<style>
		@page {
			size: 78mm 130mm;
			margin-top: 20;
			margin-right: 0;
			margin-left: 0mm;
			margin-right: 0;
		}

		html,
		body {
			width: 78mm;
			height: 78mm;
			font-family: Arial, sans-serif;
			font-size: 10pt;
			text-align: center;
			background: #fff;
		}

		.container {
			width: 78mm;
			box-sizing: border-box;
			text-align: center;
			/* Menyesuaikan teks agar terpusat */
		}

		.judul {
			font-size: 15pt;
			font-weight: bold;
			margin-bottom: 6px;
		}

		.nomor-antrian {
			font-size: 27pt;
			font-weight: bold;
			margin: 10px 0;
		}

		.tanggal {
			margin-bottom: 3px;
			font-size: 12pt;
		}

		.alamat {
			font-size: 8pt;
			color: #666;
			margin-bottom: 3px;
		}

		.footer {
			margin-top: 5px;
			font-size: 8pt;
			word-break: break-word;
		}

		hr {
			border: 0;
			border-top: 1px dashed #000;
			margin: 5px 0;
		}
	</style>
</head>

<body>
	<div class="container">
		<!-- Logo di atas judul -->
		<img src="images/logo-besar.png" alt="Logo" style="width:60px; height:auto; margin-bottom:4px;">

		<!-- Nama barber + nama cabang -->
		<div style="font-size:16pt; font-weight:bold; margin-bottom:2px;">
			Demine Barbers
		</div>
		<div style="font-size:11pt; font-weight:normal; margin-bottom:4px;">
			{{ $cabang->name }}
		</div>

		<hr>

		<div class="judul">Nomor Antrian</div>
		<div class="nomor-antrian">{{ $queue->nomor_antrian }}</div>
		<div class="tanggal">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
		<div class="alamat">{{ $cabang->lokasi->first()->alamat ?? '-' }}</div>

		<hr>

		<div class="footer">
			Pelanggan: {{ $queue->customer->nama ?? '-' }} <br>
			Produk: {{ $queue->produk->judul ?? '-' }} <br>
			Harga: Rp {{ number_format($queue->produk->harga ?? 0, 0, ',', '.') }}
		</div>

		@if (isset($qrCode))
			<div style="margin-top:10px;">
				<img src="{{ $qrCode }}" alt="QR Code" style="width:80px; height:auto;">
				<div style="font-size:7pt; margin-top:3px;">Scan untuk validasi</div>
			</div>
		@endif

	</div>
</body>

</html>
