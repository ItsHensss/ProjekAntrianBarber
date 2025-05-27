<x-filament::widget>
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">Gambaran Kursi Chapster</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($chairs as $chair)
                @php
                    $isOccupied = $chair->is_occupied;
                    $employeeName = $chair->employee->full_name ?? 'Tidak ada pegawai';
                    $customerName = $chair->customer->name ?? null;

                    // Ambil nomor antrian aktif (misal status = 'menunggu' atau 'dilayani')
                    $currentQueue = $chair->queue()
                        ->where('status', '!=', 'selesai')
                        ->orderBy('created_at', 'asc')
                        ->first();

                    $nomorAntrian = $currentQueue?->nomor_antrian;
                @endphp

                <div class="border p-4 rounded-lg shadow text-center transition
                    {{ $isOccupied ? 'bg-red-100 border-red-400' : 'bg-green-100 border-green-400' }}">
                    <div class="font-bold text-lg mb-1">{{ $chair->nama }}</div>
                    <div class="text-gray-900 font-medium">{{ $employeeName }}</div>

                    @if ($isOccupied && $customerName)
                        <div class="mt-2 text-sm text-red-800">Pelanggan: {{ $customerName }}</div>
                    @else
                        <div class="mt-2 text-sm text-green-800">Kursi Kosong</div>
                    @endif

                    @if ($nomorAntrian)
                        <div class="mt-1 text-xs text-gray-600">Antrian No: {{ $nomorAntrian }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>
