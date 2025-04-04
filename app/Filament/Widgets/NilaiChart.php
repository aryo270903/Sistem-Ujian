<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\TryOut;

class NilaiChart extends BarChartWidget
{
    protected static ?string $heading = 'Statistik Nilai Ujian';

    protected function getData(): array
    {
        // Ambil data nilai dari tabel TryOut
        $data = TryOut::with(['package.questions', 'tryOutAnswers'])
            ->get()
            ->map(function ($record) {
                $totalQuestions = $record->package->questions->count();
                $totalScore = $record->tryOutAnswers->sum('score');
                return $totalQuestions > 0 ? round($totalScore / ($totalQuestions / 10), 2) : 0;
            });

        return [
            'labels' => range(1, $data->count()),
            'datasets' => [
                [
                    'label' => 'Skor Ujian',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 2,
                    'data' => $data->toArray(),
                ],
            ],
            'options' => [
                'scales' => [
                    'x' => [
                        'title' => ['display' => true, 'text' => 'Peserta'],
                    ],
                    'y' => [
                        'title' => ['display' => true, 'text' => 'Skor'],
                        'beginAtZero' => true,
                    ],
                ],
                'plugins' => [
                    'tooltip' => [
                        'callbacks' => [
                            'label' => function($tooltipItem) {
                                return 'Skor: ' . $tooltipItem['raw'];
                            },
                        ],
                    ],
                ],
            ],
        ];
    }
}
