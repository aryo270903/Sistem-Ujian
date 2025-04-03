<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\TryoutOnline;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Http\Controllers\SiswaLoginController;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/do-tryout/{packageId}', TryoutOnline::class)->name('do-tryout');
});

Route::get('/login', function() {
    return redirect('admin/login');
})->name('login');

Route::get('/user/{id}/download-pdf', function ($id) {
    $user = User::findOrFail($id);
    $pdf = Pdf::loadView('livewire.kartu_ujian', compact('user'));
    return $pdf->download('kartu_ujian_' . $user->nomor_induk . '.pdf');
})->name('download.card');

Route::get('/download/cards', function (\Illuminate\Http\Request $request) {
    $ids = explode(',', $request->query('ids'));
    $users = User::whereIn('id', $ids)->get();

    $pdf = Pdf::loadView('livewire.kartu_ujian_masal', compact('users'));
    return $pdf->download('kartu_ujian.pdf');
})->name('download.cards');

Route::get('/siswa/login', [SiswaLoginController::class, 'showLoginForm'])->name('siswa.login');
Route::post('/siswa/login', [SiswaLoginController::class, 'login'])->name('siswa.login.submit');

Route::get('/', function () {
    return view('welcome');
});
