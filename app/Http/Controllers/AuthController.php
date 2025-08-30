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
use Illuminate\Support\Facades\URL;
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
                'birth_place' => ['nullable', 'string', 'max:255'], // opsional
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
            $otpCode = rand(100000, 999999); // kode OTP 6 digit

            // Mulai transaksi
            DB::transaction(function () use ($request, &$user, $plainPassword, $otpCode) {
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
                    'verification_expires_at' => Carbon::now()->addMinutes(15), // berlaku 15 menit
                ]);

                $defaultRole = Role::where('name', 'User')->first();
                if ($defaultRole) {
                    $user->roles()->attach($defaultRole->id);
                }
            });

            // Kirim OTP lewat email
            $verificationUrl = URL::temporarySignedRoute(
                'verifyOtp',
                now()->addMinutes(15), // link berlaku 15 menit
                ['id' => $user->id]
            );

            Mail::to($user->email)->send(new UserVerificationMail(
                $user->name,
                $otpCode,
                $verificationUrl
            ));


            return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan cek email untuk kode verifikasi.');

        } catch (\Exception $e) {
            Log::error('Error saat register user: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }

   public function showVerify(Request $request, $id)
    {
        // Laravel otomatis validasi signature lewat middleware 'signed'

        $user = User::findOrFail($id);

        if (now()->greaterThan($user->verification_expires_at)) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Link verifikasi sudah kadaluarsa.']);
        }

        return view('auth.verify', [
            'maskedEmail' => str($user->email)->mask('*', 3, 5), // sekadar masking
            'userId'      => $user->id,
            'user' => $user
        ]);
    }


    // Function baru untuk verifikasi kode OTP
    public function processVerification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'verification_code' => 'required|numeric|digits:6',
        ]);

        $user = User::where('id', $request->user_id)
                    ->where('status_id', 8) // status "Verifikasi"
                    ->first();

        if (!$user) {
            Log::warning('Verification failed: User not found or already verified.', [
                'user_id' => $request->user_id
            ]);
            return back()->withErrors(['error' => 'Akun tidak ditemukan atau sudah terverifikasi.']);
        }

        // Cek expired
        if (now()->greaterThan($user->verification_expires_at)) {
            Log::warning('Verification failed: Expired code.', [
                'user_id' => $user->id
            ]);
            return back()->withErrors(['verification_code' => 'Kode verifikasi sudah kadaluwarsa. Silakan kirim ulang.']);
        }

        // Cek kode OTP (pakai hash biar aman)
        if ($request->verification_code !== $user->verification_code) {
            return back()->withErrors(['verification_code' => 'Kode verifikasi salah.']);
        }


        // Update status user → Registered
        $user->update([
            'status_id' => 1, // Registered
            'verification_code' => null,
            'verification_expires_at' => null,
        ]);

        Log::info('User successfully verified.', [
            'user_id' => $user->id,
            'email'   => $user->email
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil diverifikasi! Silakan login.');
    }

    // Function untuk mengirim ulang OTP
    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->where('status_id', 8)->first();

        if (!$user) {
            Log::error('Resend OTP failed: User not found or already verified.', ['email' => $request->email]);
            return back()->withErrors(['error' => 'Akun tidak ditemukan atau sudah terverifikasi.']);
        }

        try {
            $otpCode = random_int(100000, 999999);
            $user->verification_code = $otpCode;
            $user->verification_expires_at = now()->addMinutes(15);
            $user->save();

            Mail::to($user->email)->queue(new UserVerificationMail($user->name, $otpCode));
            Log::info('New OTP sent successfully.', ['email' => $user->email]);

            return back()->with('success', 'Jika email terdaftar, kode verifikasi baru sudah dikirim.');
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email.', ['email' => $user->email, 'error' => $e->getMessage()]);
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