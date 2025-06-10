<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Laporan Ringkasan</title>
	<style>
		body {
			font-family: sans-serif;
			font-size: 12px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		th,
		td {
			border: 1px solid #333;
			padding: 5px;
			text-align: center;
		}

		th {
			background: #eee;
		}
	</style>
</head>

<body>
	<h2 style="text-align:center;">Laporan Ringkasan</h2>
	<p><strong>Periode:</strong> {{ $from }} s/d {{ $until }}</p>
	<table>
		<thead>
			<tr>
				<th>Nama Karyawan</th>
				<th>Jenis Layanan</th>
				@foreach ($dates as $date)
					<th>{{ $date }}</th>
				@endforeach
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($summary as $karyawan => $layanans)
				@foreach ($layanans as $layanan => $items)
					<tr>
						<td>{{ $karyawan }}</td>
						<td>{{ $layanan }}</td>
						@foreach ($dates as $date)
							<td>{{ $items[$date] ?? 0 }}</td>
						@endforeach
						<td><strong>{{ $items['total'] }}</strong></td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
</body>

</html>
