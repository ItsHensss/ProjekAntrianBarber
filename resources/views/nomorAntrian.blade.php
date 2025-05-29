<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title>Tampilan Nomor Antrian</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		html,
		body {
			height: 100%;
			margin: 0;
			padding: 0;
		}

		body {
			background-color: #000;
			color: #fff;
			font-family: Arial, sans-serif;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.center-container {
			width: 100%;
			max-width: 700px;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}

		.nomor-antrian {
			font-size: clamp(48px, 22vw, 180px);
			font-weight: bold;
			margin: 3vw 0 2vw;
			line-height: 1;
		}

		.judul {
			font-size: clamp(24px, 6vw, 56px);
			font-weight: 600;
		}

		.tanggal {
			font-size: clamp(16px, 3vw, 32px);
			margin-top: 1vw;
		}

		.kode-proyek {
			font-size: clamp(12px, 2vw, 22px);
			margin-top: 1vw;
			color: #ccc;
		}
	</style>
</head>

<body>
	<div class="center-container">
		<div class="judul">Nomor Antrian</div>
		<div id="nomor-antrian" class="nomor-antrian">-</div>
		<div class="tanggal" id="tanggal"></div>
		<div class="kode-proyek">Kode Proyek: FLV-QUEUE-DISPLAY</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
	<script>
		function tampilkanTanggal() {
			const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
			const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
			const t = new Date();
			const teksTanggal = `${hari[t.getDay()]}, ${t.getDate()} ${bulan[t.getMonth()]} ${t.getFullYear()}`;
			$('#tanggal').text(teksTanggal);
		}

		function ambilNomorAntrian() {
			$.ajax({
				url: "{{ route('antrian.today.json') }}",
				method: "GET",
				success: function(data) {
					if (data.length > 0) {
						const terakhir = data[data.length - 1];
						$('#nomor-antrian').text(terakhir.nomor_antrian);
					} else {
						$('#nomor-antrian').text('-');
					}
				},
				error: function() {
					$('#nomor-antrian').text('Error');
				}
			});
		}

		$(document).ready(function() {
			tampilkanTanggal();
			ambilNomorAntrian();
			setInterval(ambilNomorAntrian, 5000);
		});
	</script>
</body>

</html>
