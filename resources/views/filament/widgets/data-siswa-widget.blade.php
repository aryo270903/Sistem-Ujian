<x-filament::widget>
    <div class="grid grid-cols-2 gap-4">
        <x-filament::card class="p-6 shadow-xl border border-gray-200 rounded-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Biodata Diri</h2>
            <div class="space-y-2 text-gray-700">
                @if(auth()->user()->hasRole('siswa'))
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Nomor Induk:</span>
                        <span>{{ $this->getData()['nomor_induk'] ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Nama Lengkap:</span>
                        <span>{{ $this->getData()['name'] ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Jenis Kelamin (L/P):</span>
                        <span>{{ $this->getData()['jenis_kelamin'] ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">NIK:</span>
                        <span>{{ $this->getData()['nik'] ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">NISN:</span>
                        <span>{{ $this->getData()['nisn'] ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Tempat Lahir:</span>
                        <span>{{ $this->getData()['tempat_lahir'] ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Tanggal Lahir (dd-mm-yyyy):</span>
                        <span>{{ $this->getData()['tanggal_lahir'] ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Alamat:</span>
                        <span>{{ $this->getData()['alamat'] ?? 'Tidak Ada' }}</span>
                    </div>
                @else
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Email:</span>
                        <span>{{ auth()->user()->email ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Nama Lengkap:</span>
                        <span>{{ auth()->user()->name ?? 'Tidak Ada' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Jenis Kelamin (L/P):</span>
                        <span>{{ $this->getData()['jenis_kelamin'] ?? 'Tidak Ada' }}</span>
                    </div>
                @endif
            </div>
        </x-filament::card>
    </div>
</x-filament::widget>
