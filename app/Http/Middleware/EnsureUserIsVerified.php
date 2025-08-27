<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->status_id == 8) {
            // Jika belum verifikasi, redirect ke halaman verifikasi OTP
            return redirect()->route('verifyOtp')->with('error', 'Silakan verifikasi akun Anda terlebih dahulu.');
        }

        return $next($request);
    }
}
