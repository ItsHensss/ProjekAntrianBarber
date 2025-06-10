<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title>Laporan Transaksi</title>
	<style>
		body {
			font-family: DejaVu Sans, sans-serif;
			font-size: 12px;
			color: #333;
		}

		h2 {
			text-align: center;
			margin-bottom: 10px;
		}

		.date-range {
			text-align: center;
			margin-bottom: 20px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin: auto;
		}

		table,
		th,
		td {
			border: 1px solid #999;
		}

		th,
		td {
			padding: 6px;
			text-align: left;
		}

		thead {
			background-color: #f0f0f0;
		}
	</style>
</head>

<body>
	<h2>Laporan Transaksi</h2>
	<div class="date-range">
		Periode: {{ $from }} s.d. {{ $until }}
	</div>

	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal Booking</th>
				<th>Nama Pelanggan</th>
				<th>Produk</th>
				<th>Harga</th>
				<th>Chapster</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $i => $item)
				<tr>
					<td>{{ $i + 1 }}</td>
					<td>{{ \Carbon\Carbon::parse($item->booking_date)->format('d-m-Y') }}</td>
					<td>{{ $item->customer->nama ?? '-' }}</td>
					<td>{{ $item->produk->judul ?? '-' }}</td>
					<td>Rp {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</td>
					<td>{{ $item->user->name ?? '-' }}</td>
					<td>{{ $item->status }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>
