<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title>Print Antrian</title>
	<style>
		@page {
			size: 80mm 100mm;
			margin: 0;
		}

		html,
		body {
			width: 80mm;
			height: 100mm;
			margin: 0;
			padding: 0;
			font-family: Arial, sans-serif;
			font-size: 10pt;
			text-align: center;
			background: #fff;
		}

		.container {
			width: 76mm;
			margin: 0 auto;
			padding: 4mm 2mm;
			box-sizing: border-box;
		}

		.judul {
			font-size: 14pt;
			font-weight: bold;
			margin-bottom: 6px;
		}

		.nomor-antrian {
			font-size: 36pt;
			font-weight: bold;
			margin: 10px 0;
		}

		.tanggal {
			margin-bottom: 6px;
			font-size: 10pt;
		}

		.alamat {
			font-size: 9pt;
			color: #666;
			margin-bottom: 6px;
		}

		.footer {
			margin-top: 10px;
			font-size: 9pt;
			word-break: break-word;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="judul">Nomor Antrian {{ $cabang->name }}</div>
		<div class="nomor-antrian">{{ $queue->nomor_antrian }}</div>
		<div class="tanggal">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
		<div class="alamat">{{ $cabang->lokasi->first()->alamat ?? '-' }}</div>

		<div class="footer">
			Pelanggan: {{ $queue->customer->nama ?? '-' }} <br>
			Produk: {{ $queue->produk->judul ?? '-' }} <br>
			Harga: Rp {{ number_format($queue->produk->harga ?? 0, 0, ',', '.') }}
		</div>
	</div>
</body>

</html>
