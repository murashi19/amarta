<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        $user = null;
        DB::transaction(function () use ($request, &$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
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

        Auth::login($user);
        return $this->redirectToDashboard()->with('success', 'Pendaftaran Berhasil');
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
            return $this->redirectToDashboard();
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

    // --- Helper: Redirect sesuai role ---
    private function redirectToDashboard()
    {
        $user = Auth::user();
        if ($user->roles()->where('name', 'admin')->exists()) {
            return redirect()->route('dashboard.admin');
        }
        return redirect()->route('dashboard.user');
    }
}