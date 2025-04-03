<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<div class="md:col-span-2 bg-white shadow-md rounded-lg p-6">
        @if($tryOut->finished_at == null)
            <div class="text-center mb-4">
                <h2 class="text-xl font-bold mb-2">Sisa Waktu</h2>
                <div class="text-gray-700 text-lg" id="time">
                    @if($timeLeft > 0) 00:00:00 @else HABIS @endif
                </div>
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-4">{{$package->name}}</h2>
        <p class="text-gray-700">{!! $currentPackageQuestion->question->question !!}</p>

        @if($currentPackageQuestion->question->question_image)
            <div class="mt-4 mb-4">
                <img src="{{ asset('storage/' . $currentPackageQuestion->question->question_image) }}" alt="Question Image" class="w-full h-auto rounded-lg shadow-md">
            </div>
        @endif

        
        <div class="mt-4">
        @foreach($currentPackageQuestion->question->options as $index => $item)
                @php
                    $answer = $tryOutAnswers->where('question_id', $currentPackageQuestion->question_id)->first();
                    $isSelected = $answer ? $answer->option_id == $item->id : false;
                    // Define letters dynamically based on number of options
                    $letters = range('a', 'z'); // You can extend this as needed
                @endphp
                <label class="block mb-2">
                    <input
                        id="option_{{ $currentPackageQuestion->question_id }}_{{$item->id}}"
                        type="radio"
                        name="option"
                        class="mr-2 option-radio"
                        wire:click="saveAnswer({{ $currentPackageQuestion->question_id }}, {{ $item->id }})"
                        value="{{ $item->id }}"
                        @if($timeLeft <= 0) disabled @endif
                        @if($isSelected) checked @endif>
                    {{ strtoupper($letters[$index]) }}. {{ $item->option_text }}
                </label>
            @endforeach
        </div>
    </div>



    <div class="md:col-span-1 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Navigasi Soal</h2>

        @foreach($questions as $index => $item)
            @php 
                $isAnswered = isset($selectedAnswers[$item->question_id]) && !is_null($selectedAnswers[$item->question_id]); 
                $isActive = $currentPackageQuestion->id === $item->id; 
            @endphp

            <x-filament::button 
                wire:click="goToQuestion({{ $item->id }})" 
                class="mb-2 navigation-button" 
                color="{{ $isActive ? 'warning' : ($isAnswered ? 'success' : 'gray') }}">
                {{ $index+1 }}
            </x-filament::button>
        @endforeach

        @if($tryOut->finished_at == null)
            @php
                $isLastQuestion = $currentPackageQuestion->id === $questions->last()->id;
            @endphp
            <x-filament::button wire:click="goToQuestion" class="btn w-full bg-blue-500 text-white py-2 rounded mt-3">
                {{ $isLastQuestion ? 'Submit' : 'Next' }}
            </x-filament::button>
        @endif
    </div>

    @if($tryOut->finished_at != null)
        <div class="bg-green-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <a href="{{url('/admin/tryouts')}}" class="underline">Lihat Hasil Pengerjaan</a>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let timeLeft = {{$timeLeft}};
        let display = document.getElementById('time');

        // Cek apakah waktu sudah habis di localStorage
        if (localStorage.getItem('timeExpired') === 'true') {
            disableAllInputs();
            display.textContent = "HABIS";
        } else {
            startCountdown(timeLeft, display);
        }
    });

    function startCountdown(duration, display) {
        let timer = duration, hours, minutes, seconds;
        let countdown = setInterval(function() {
            if (timer <= 0) {
                clearInterval(countdown);
                display.textContent = "HABIS";
                disableAllInputs();
                localStorage.setItem('timeExpired', 'true'); // Simpan status waktu habis
                return;
            }
            hours = parseInt(timer / 3600, 10);
            minutes = parseInt((timer % 3600) / 60, 10);
            seconds = parseInt(timer % 60, 10);
            display.textContent = 
                (hours < 10 ? "0" + hours : hours) + ":" + 
                (minutes < 10 ? "0" + minutes : minutes) + ":" + 
                (seconds < 10 ? "0" + seconds : seconds);
            timer--;
        }, 1000);
    }

    function disableAllInputs() {
        document.querySelectorAll('.option-radio, .navigation-button').forEach(el => {
            el.disabled = true;
        });
        window.livewire.emit('disableAll');
    }

    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('showSubmitConfirmation', () => {
            if (confirm("Apakah Anda yakin ingin mengirim jawaban ini? Mohon periksa kembali.")) {
                Livewire.emit('submit'); // Jika pilih "Ya", panggil submit()
            }
        });
    });

</script>
