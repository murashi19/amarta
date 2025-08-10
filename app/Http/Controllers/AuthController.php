<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'education_level' => ['required', 'string', 'max:255'],
        ]);

        $plainPassword = $request->password; // simpan sebelum di-hash

        $user = null;
        DB::transaction(function () use ($request, &$user, $plainPassword) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($plainPassword),
                'phone_number' => $request->phone_number,
                'status_id' => 1, // Registered
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'education_level' => $request->education_level,
            ]);

            // Tambah role default User
            $defaultRole = Role::where('name', 'User')->first();
            if ($defaultRole) {
                $user->roles()->attach($defaultRole->id);
            }
        });

        // Kirim email ke user
        Mail::to($user->email)->send(new UserRegisteredMail($user->name, $user->email, $plainPassword));

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan cek email Anda untuk informasi akun.');
    }

    // Halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
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
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}