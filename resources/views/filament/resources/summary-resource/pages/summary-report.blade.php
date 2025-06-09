<x-filament::page>
	<h2 class="mb-4 text-lg font-bold">Laporan Ringkasan</h2>

	<table class="min-w-full table-auto border-collapse border border-gray-300">
		<thead>
			<tr class="bg-gray-100">
				<th class="border px-4 py-2">Nama Karyawan</th>
				<th class="border px-4 py-2">Jenis Layanan</th>
				@foreach ($data['dates'] as $date)
					<th class="border px-4 py-2">{{ $date }}</th>
				@endforeach
				<th class="border px-4 py-2">Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data['summary'] as $karyawan => $layanans)
				@foreach ($layanans as $layanan => $items)
					<tr>
						<td class="border px-4 py-2">{{ $karyawan }}</td>
						<td class="border px-4 py-2">{{ $layanan }}</td>
						@foreach ($data['dates'] as $date)
							<td class="border px-4 py-2 text-center">{{ $items[$date] ?? 0 }}</td>
						@endforeach
						<td class="border px-4 py-2 text-center font-semibold">{{ $items['total'] }}</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
</x-filament::page>
