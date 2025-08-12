<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Status;
use App\Mail\UserVerificationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; 

class AuthController extends Controller
{
    // Halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phone_number' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'birth_date' => ['required', 'date'],
                'education_level' => ['required', 'string', 'max:255'],
            ]);

            $plainPassword = $request->password;
            $otpCode = rand(100000, 999999); // OTP 6 digit angka

            $user = null;
            DB::transaction(function () use ($request, &$user, $plainPassword, $otpCode) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($plainPassword),
                    'phone_number' => $request->phone_number,
                    'status_id' => 8 || Status::where('name', 'Verifikasi')->first()->id,
                    'address' => $request->address,
                    'birth_date' => $request->birth_date,
                    'education_level' => $request->education_level,
                    'verification_code' => $otpCode,
                    'verification_expires_at' => Carbon::now()->addMinutes(15), // berlaku 15 menit
                ]);

                $defaultRole = Role::where('name', 'User')->first();
                if ($defaultRole) {
                    $user->roles()->attach($defaultRole->id);
                }
            });

            // Kirim OTP lewat email
            Mail::to($user->email)->send(new UserVerificationMail($user->name, $otpCode));

            return redirect()->route('verifyOtp', ['email' => $user->email])
                ->with('success', 'Registrasi berhasil! Silakan cek email untuk kode verifikasi.');
        } catch (\Exception $e) {
            Log::error('Error saat register user: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }

    public function showVerify(Request $request)
    {
        // Pastikan email ada di session atau query string untuk ditampilkan di form
        $email = $request->get('email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['error' => 'Email tidak ditemukan.']);
        }
        return view('auth.verify', compact('email'));
    }

    // Function baru untuk verifikasi kode OTP
    public function processVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|digits:6', // Pastikan kode OTP 6 digit
        ]);

        $user = User::where('email', $request->email)
                    ->where('status_id', 8) // Cari user yang belum aktif
                    ->first();

        // Cek apakah user ada
        if (!$user) {
            return back()->withErrors(['error' => 'Akun tidak ditemukan atau sudah terverifikasi.']);
        }

        // Cek apakah kode OTP yang dimasukkan sama dengan yang ada di database
        if ($user->verification_code != $request->verification_code) {
            return back()->withErrors(['verification_code' => 'Kode verifikasi salah.']);
        }

        // Cek apakah kode OTP sudah kadaluwarsa
        if (Carbon::now()->greaterThan($user->verification_expires_at)) {
            return back()->withErrors(['verification_code' => 'Kode verifikasi sudah kadaluwarsa. Silakan kirim ulang.']);
        }

        // Jika semua validasi berhasil, update status user menjadi aktif
        $user->status_id = 1; // Ubah status menjadi aktif
        $user->email_verified_at = now(); // Beri timestamp verifikasi
        $user->verification_code = null; // Hapus kode OTP setelah verifikasi
        $user->verification_expires_at = null;
        $user->save();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil diverifikasi! Silakan login.');
    }

    // Function untuk mengirim ulang OTP
    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->where('status_id', 8)->first();

        if (!$user) {
            return back()->withErrors(['error' => 'Akun tidak ditemukan atau sudah terverifikasi.']);
        }

        $otpCode = rand(100000, 999999);
        $user->verification_code = $otpCode;
        $user->verification_expires_at = now()->addMinutes(15);
        $user->save();

        // Kirim email dengan kode OTP baru
        Mail::to($user->email)->send(new UserVerificationMail($user->name, $otpCode));

        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }


    // Halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                // Cek role user
                $user = Auth::user();

                if ($user->roles()->where('name', 'admin')->exists()) {
                    return redirect()->route('dashboard.admin');
                }

                return redirect()->route('dashboard.users');
            }

            return back()->withErrors(['email' => 'Email atau password salah']);
        } catch (\Exception $e) {
            Log::error('Error saat login: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->only('email'),
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat login. Silakan coba lagi.']);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        } catch (\Exception $e) {
            Log::error('Error saat logout: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->withErrors(['error' => 'Gagal logout.']);
        }
    }
}
