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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
                'phone_number' => ['required', 'string', 'max:255', 'unique:users,phone_number'],
                'address' => ['required', 'string', 'max:255'],
                'birth_place' => ['nullable', 'string', 'max:255'],
                'birth_date' => ['required', 'date'],
                'education_level' => [
                    'required',
                    Rule::in([
                        'SMP/Sederajat',
                        'SMA/SMK/Sederajat',
                        'Diploma 3 (D3)',
                        'Sarjana (S1)',
                        'Lainnya'
                    ])
                ],
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            ]);

            $plainPassword = $request->password;
            $otpCode = rand(100000, 999999);

            // Generate token
            $token = Str::random(64);

            DB::transaction(function () use ($request, &$user, $plainPassword, $otpCode, $token) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($plainPassword),
                    'phone_number' => $request->phone_number,
                    'status_id' => 8, // status Verifikasi
                    'gender' => $request->gender,
                    'birth_place' => $request->birth_place,
                    'address' => $request->address,
                    'birth_date' => $request->birth_date,
                    'education_level' => $request->education_level,
                    'verification_code' => $otpCode,
                    'verification_expires_at' => Carbon::now()->addMinutes(15),
                    'verification_token' => hash('sha256', $token), // simpan HASH, bukan plain
                ]);

                $defaultRole = Role::where('name', 'User')->first();
                if ($defaultRole) {
                    $user->roles()->attach($defaultRole->id);
                }
            });

            // 🔐 Enkripsi plain token agar URL lebih aman
            $encryptedToken = Crypt::encryptString($token);
            $verificationUrl = route('verifyOtp', ['token' => $encryptedToken]);

            Mail::to($user->email)->send(new UserVerificationMail(
                $user->name,
                $otpCode,
                $verificationUrl
            ));

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan cek email untuk verifikasi.');
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
        try {
            $encryptedToken = $request->get('token');
            if (!$encryptedToken) {
                return redirect()->route('login')->withErrors(['error' => 'Token verifikasi tidak ditemukan.']);
            }

            // 🔐 Decrypt token
            $plainToken = Crypt::decryptString($encryptedToken);

            // Cari user berdasarkan HASH dari plain token
            $user = User::where('verification_token', hash('sha256', $plainToken))
                ->where('verification_expires_at', '>=', now())
                ->first();

            if (!$user) {
                return redirect()->route('login')
                    ->withErrors(['error' => 'Token verifikasi tidak valid atau sudah kadaluarsa.']);
            }

            return view('auth.verify', [
                'email' => $user->email,
                'token' => $encryptedToken, // tetep kirim token terenkripsi ke form
            ]);
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Token verifikasi tidak valid.']);
        }
    }

    public function processVerification(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'verification_code' => 'required|numeric|digits:6',
        ]);

        try {
            // 🔐 Decrypt token yang dikirim dari form
            $plainToken = Crypt::decryptString($request->token);
        } catch (\Exception $e) {
            Log::error('Verification failed: Invalid token.', ['token' => $request->token]);
            return back()->withErrors(['error' => 'Token verifikasi tidak valid.']);
        }

        // Cari user berdasarkan token hash
        $user = User::where('verification_token', hash('sha256', $plainToken))
                    ->where('status_id', 8) // status Verifikasi
                    ->first();

        if (!$user) {
            Log::error('Verification failed: User not found or already verified.');
            return back()->withErrors(['error' => 'Akun tidak ditemukan atau sudah terverifikasi.']);
        }

        // Cek apakah kode OTP sudah kadaluarsa
        if (Carbon::now()->greaterThan($user->verification_expires_at)) {
            Log::warning('Verification failed: Expired code.', ['email' => $user->email]);
            return back()->withErrors(['verification_code' => 'Kode verifikasi sudah kadaluwarsa. Silakan kirim ulang.']);
        }

        // Cek apakah kode OTP sesuai
        if ($user->verification_code != $request->verification_code) {
            Log::warning('Verification failed: Incorrect code.', [
                'email' => $user->email,
                'input_code' => $request->verification_code,
                'expected_code' => $user->verification_code
            ]);
            return back()->withErrors(['verification_code' => 'Kode verifikasi salah.']);
        }

        // ✅ Jika semua validasi berhasil, update status user jadi Registered
        $user->update([
            'status_id' => 1, // Registered
            'verification_code' => null,
            'verification_expires_at' => null,
            'verification_token' => null, // buang token biar link gak bisa dipakai ulang
        ]);

        Log::info('User successfully verified.', ['email' => $user->email]);

        return redirect()->route('login')->with('success', 'Akun berhasil diverifikasi! Silakan login.');
    }



    // Function untuk mengirim ulang OTP
    public function resendOtp(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        try {
            // 🔐 Decrypt token dari request
            $plainToken = Crypt::decryptString($request->token);
        } catch (\Exception $e) {
            Log::error('Resend OTP failed: Invalid token.', ['token' => $request->token]);
            return back()->withErrors(['error' => 'Token tidak valid.']);
        }

        $user = User::where('verification_token', hash('sha256', $plainToken))
                    ->where('status_id', 8)
                    ->first();

        if (!$user) {
            Log::error('Resend OTP failed: User not found or already verified.');
            return back()->withErrors(['error' => 'Akun tidak ditemukan atau sudah terverifikasi.']);
        }

        // 🚦 Batasi request OTP (misalnya 1 menit sekali)
        if ($user->last_otp_sent_at && $user->last_otp_sent_at->diffInSeconds(now()) < 120) {
            return back()->withErrors(['error' => 'Anda baru saja meminta OTP. Silakan tunggu 2 menit sebelum mencoba lagi.']);
        }

        try {
            $otpCode = rand(100000, 999999);

            $user->update([
                'verification_code' => $otpCode,
                'verification_expires_at' => now()->addMinutes(15),
                'last_otp_sent_at' => now(), // tambahin kolom ini di DB
            ]);

            // 🔗 Buat ulang link verifikasi terenkripsi
            $encryptedToken = Crypt::encryptString($plainToken);
            $verificationUrl = route('verifyOtp', ['token' => $encryptedToken]);

            Mail::to($user->email)->send(new UserVerificationMail(
                $user->name,
                $otpCode,
                $verificationUrl
            ));

            Log::info('New OTP sent successfully.', ['email' => $user->email]);

            return back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email.', [
                'email' => $user->email,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['error' => 'Gagal mengirim email verifikasi. Silakan coba lagi.']);
        }
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

                $user = Auth::user();

                // 🔒 Cek apakah user sudah verifikasi atau belum
                if ($user->status_id == 8) { // 8 = belum verifikasi
                    Auth::logout(); // langsung logout agar tidak dapat akses
                    return redirect()->route('verifyOtp', ['email' => $user->email])
                        ->withErrors(['error' => 'Akun Anda belum diverifikasi. Silakan masukkan kode OTP.']);
                }

                // ✅ Jika sudah verifikasi, cek role
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
