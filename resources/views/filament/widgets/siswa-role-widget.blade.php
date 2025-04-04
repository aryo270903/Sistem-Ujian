<x-filament::widget>
    <x-filament::stats-overview>
        @if(auth()->user()->hasRole('siswa') || auth()->user()->hasRole('guru'))
            {{ $this->getCards() }}
        @endif
    </x-filament::stats-overview>
</x-filament::widget>
