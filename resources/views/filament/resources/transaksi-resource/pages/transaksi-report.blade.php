<x-filament::page>
	<h2 class="mb-4 text-lg font-bold text-gray-900 dark:text-gray-100">Laporan Transaksi</h2>

	<form wire:submit.prevent="getData" class="mb-6 space-y-4">
		<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
			<x-filament::input type="date" wire:model.defer="from" label="Tanggal Awal" />
			<x-filament::input type="date" wire:model.defer="until" label="Tanggal Akhir" />
			<div class="flex items-end gap-3">
				<x-filament::button type="submit" class="w-full md:w-auto">Tampilkan</x-filament::button>
				<x-filament::button tag="a" href="{{ route('transaksi.export.pdf', ['from' => $from, 'until' => $until]) }}" target="_blank" color="gray"
					class="w-full md:w-auto">
					PDF
				</x-filament::button>
			</div>
		</div>
	</form>
	<div class="overflow-x-auto">
		<table class="min-w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
			<thead>
				<tr class="bg-gray-100 dark:bg-gray-800">
					<th class="border px-4 py-2">Tanggal</th>
					<th class="border px-4 py-2">Pelanggan</th>
					<th class="border px-4 py-2">Produk</th>
					<th class="border px-4 py-2">Harga</th>
					<th class="border px-4 py-2">Chapster</th>
					<th class="border px-4 py-2">Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $item)
					<tr class="bg-white dark:bg-gray-900">
						<td class="border px-4 py-2">{{ $item->booking_date }}</td>
						<td class="border px-4 py-2">{{ $item->customer->nama ?? '-' }}</td>
						<td class="border px-4 py-2">{{ $item->produk->judul ?? '-' }}</td>
						<td class="border px-4 py-2">Rp {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</td>
						<td class="border px-4 py-2">{{ $item->user->name ?? '-' }}</td>
						<td class="border px-4 py-2">{{ $item->status }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</x-filament::page>
