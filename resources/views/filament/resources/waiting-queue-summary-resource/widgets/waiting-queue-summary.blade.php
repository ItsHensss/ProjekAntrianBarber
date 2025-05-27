<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <!-- Kolom Kiri: Antrian Menunggu -->
            <div class="flex flex-col items-center justify-center bg-gray-900 p-6 rounded-xl h-full">
                <h2 class="text-orange-500 text-2xl font-bold">No Antrian</h2>
                <div class="text-white font-extrabold mt-2" style="font-size: 8rem;">{{ $this->getData()['noQueue'] }}</div>
            </div>

            <!-- Kolom Kanan: Sedang Dilayani & Selesai Hari Ini -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Sedang Menunggu -->
                <div class="bg-gray-900 p-4 rounded-xl text-center">
                    <div class="text-sm text-gray-400">Sedang Dilayani</div>
                    <div class="text-white text-3xl font-bold">{{ $this->getData()['waitingCount'] }}</div>
                </div>

                <!-- Sedang Dilayani -->
                <div class="bg-gray-900 p-4 rounded-xl text-center">
                    <div class="text-sm text-gray-400">Sedang Dilayani</div>
                    <div class="text-white text-3xl font-bold">{{ $this->getData()['beingServedCount'] }}</div>
                </div>

                <!-- Selesai Hari Ini -->
                <div class="bg-gray-900 p-4 rounded-xl text-center">
                    <div class="text-sm text-gray-400">Selesai Hari Ini</div>
                    <div class="text-white text-3xl font-bold">{{ $this->getData()['completedTodayCount'] }}</div>
                </div>
            </div>
        </div>
   </x-filament::card>
</x-filament::widget>
