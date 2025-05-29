<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title>Antrian Hari Ini</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
	<div class="container">
		<h2 class="mb-4">Daftar Antrian Hari Ini</h2>
		<table class="table-bordered table" id="queueTable">
			<thead class="table-light">
				<tr>
					<th>No.</th>
					<th>Nama Pelanggan</th>
					<th>Produk</th>
					<th>Nomor Antrian</th>
					<th>Status</th>
					<th>Chapster</th>
				</tr>
			</thead>
			<tbody>
				<!-- Data akan dimuat dengan AJAX -->
			</tbody>
		</table>
	</div>

	<!-- jQuery + Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
	<script>
		function fetchQueues() {
			$.ajax({
				url: "{{ route('queues.today.json') }}",
				method: "GET",
				success: function(data) {
					let tbody = '';
					if (data.length === 0) {
						tbody = '<tr><td colspan="6" class="text-center">Belum ada antrian hari ini.</td></tr>';
					} else {
						data.forEach((item, index) => {
							tbody += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.customer?.nama ?? '-'}</td>
                                    <td>${item.produk?.judul ?? '-'}</td>
                                    <td>${item.nomor_antrian}</td>
                                    <td><span class="badge bg-${getBadgeColor(item.status)}">${item.status}</span></td>
                                    <td>${item.requested_chapster_id ?? '-'}</td>
                                </tr>
                            `;
						});
					}

					$('#queueTable tbody').html(tbody);
				},
				error: function() {
					alert('Gagal memuat data antrian.');
				}
			});
		}

		function getBadgeColor(status) {
			switch (status) {
				case 'menunggu':
					return 'warning';
				case 'selesai':
					return 'success';
				case 'batal':
					return 'danger';
				default:
					return 'secondary';
			}
		}

		// Load awal dan set interval setiap 5 detik
		$(document).ready(function() {
			fetchQueues();
			setInterval(fetchQueues, 5000); // 5 detik
		});
	</script>
</body>

</html>
