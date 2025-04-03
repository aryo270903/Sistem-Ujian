<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.siswa-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
            'otp' => 'required|string',
        ]);

        $user = User::where('nisn', $request->nisn)->first();

        if (!$user || !$user->hasRole('siswa')) {
            return back()->withErrors(['nisn' => 'NISN tidak valid atau bukan siswa.']);
        }

        $otp = OTP::where('otp', $request->otp)->where('user_id', $user->id)->first();

        if (!$otp || $otp->isExpired()) {
            return back()->withErrors(['otp' => 'OTP tidak valid atau sudah kedaluwarsa.']);
        }

        // Login user dan regenerasi session
        Auth::login($user, true);
        session()->regenerate();

        return redirect('/admin');
    }
}
