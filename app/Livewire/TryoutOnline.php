<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\Question;
use App\Models\Tryout;
use App\Models\Tryoutanswer;
use App\Models\QuestionOption;
use Auth;

class TryoutOnline extends Component
{
    public $package;
    public $questions;
    public $tryOut;
    public $currentPackageQuestion;
    public $timeLeft;
    public $tryOutAnswers;
    public $selectedAnswers = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        return view('livewire.tryout');
    }

    public function mount($packageId)
    {
        $this->package = Package::with('questions.question.options')->find($packageId);
        if ($this->package) {
            $this->questions = $this->package->questions;
            if ($this->questions->isNotEmpty()) {
                $this->currentPackageQuestion = $this->questions->first();
            }

            // Parsing setiap pertanyaan agar gambar tampil benar
            foreach ($this->questions as $question) {
                $question->question->question = preg_replace('/<figure.*?>.*?<img src="(.*?)".*?<\/figure>/i', '<img src="$1">', $question->question->question);
            }
        }

        $this->tryOut = Tryout::where('user_id', Auth::id())
        ->where('package_id', $this->package->id)
        ->whereNull('finished_at')
        ->first();
        if (!$this->tryOut) {
        $startedAt = now();
        $durationInSecond = $this->package->duration * 60;
        
        $this->tryOut = Tryout::create([
        'user_id' => Auth::id(),
        'package_id' => $this->package->id,
        'duration' => $durationInSecond,
        'started_at' => $startedAt
        ]);

        foreacH($this->questions as $question) {
            Tryoutanswer::create([
            'tryout_id' => $this->tryOut->id,
            'question_id' => $question->question_id,
            'option_id' => null,
            'score' => 0
            ]);
        }
    }

    $this->tryOutAnswers = Tryoutanswer::where('tryout_id', $this->tryOut->id)->get();
    foreach($this->tryOutAnswers as $answer) {
        $this->selectedAnswers[$answer->question_id] = $answer->option_id;

    }

    $this->calculateTimeLeft();
}

    public function goToQuestion($package_question_id = null)
    {
        $currentIndex = $this->questions->search(fn($item) => $item->id === $this->currentPackageQuestion->id);

        // Jika pengguna memilih soal secara langsung
        if ($package_question_id) {
            $this->currentPackageQuestion = $this->questions->where('id', $package_question_id)->first();
        }
        // Jika tombol "Next" ditekan
        else if ($currentIndex !== false && $currentIndex < $this->questions->count() - 1) {
            $this->currentPackageQuestion = $this->questions->values()[$currentIndex + 1];
        }
        // Jika soal terakhir, panggil submit()
        else {
            $this->submit();
        }
        $this->calculateTimeLeft();
    }

    public function goToPreviousQuestion()
    {
        $currentIndex = $this->questions->search(fn($item) => $item->id === $this->currentPackageQuestion->id);

        if ($currentIndex !== false && $currentIndex > 0) {
            $this->currentPackageQuestion = $this->questions->values()[$currentIndex - 1];
        }
        $this->calculateTimeLeft();
    }

    protected function calculateTimeLeft()
    {
         if ($this->tryOut->finished_at) {
            $this->timeLeft = 0;
            
        } else {
            $now = time();
            $startedAt = strtotime($this->tryOut->started_at);
    
            $sisaWaktu = $now - $startedAt;
            if ($sisaWaktu < 0) {
                $this->timeLeft = 0;
            } else {
                $this->timeLeft = max(0, $this->tryOut->duration - $sisaWaktu);
            }
        }
    }

    public function saveAnswer($questionId, $optionId)
    {
        $option = QuestionOption::find($optionId);
        $score = $option->score ?? 0;

        $tryOutAnswer = Tryoutanswer::where('tryout_id', $this->tryOut->id)
                                    ->where('question_id', $questionId)
                                    ->first();

        if ($tryOutAnswer) {
            $tryOutAnswer->update([
                'option_id' => $optionId,
                'score' => $score,
            ]);
            
        }
       
        $this->selectedAnswers[$questionId] = $optionId;
        $this->tryOutAnswers = Tryoutanswer::where('tryout_id', $this->tryOut->id)->get();
        // $this->dispatchBrowserEvent('refreshComponent');
        $this->dispatch('refreshComponent');
    }

    public function submit()
    {
        $this->tryOut->update(['finished_at' => now()]);
        $this->calculateTimeLeft();
        session()->flash('message', 'Data berhasil disimpan');
    }
}