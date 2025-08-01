<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\AdminOnly;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;

// --- Landing Page ---
Route::get('/', fn() => view('landing/home'));
Route::get('/program', fn() => view('landing/program'));
Route::get('/about', fn() => view('landing/about'));
Route::get('/contact', fn() => view('landing/contact'));
Route::get('/daftar', fn() => view('landing/daftar'));
Route::get('/form', fn() => view('auth/form'));

// --- Auth Routes ---
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Dashboard Admin ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/admin', fn() => view('dashboard/admin'))->name('dashboard.admin');

    // Pengumuman khusus admin
    Route::get('/admin/pengumuman', [AnnouncementController::class, 'index'])->name('admin.pengumuman');
    Route::post('/admin/pengumuman', [AnnouncementController::class, 'store'])->name('admin.pengumuman.store');
    Route::put('/admin/pengumuman/{id}', [AnnouncementController::class, 'update'])->name('admin.pengumuman.update');
    Route::get('/admin/pengumuman/{id}/edit', [AnnouncementController::class, 'edit'])->name('admin.pengumuman.edit');
    Route::delete('/admin/pengumuman/{id}', [AnnouncementController::class, 'destroy'])->name('admin.pengumuman.destroy');
    Route::get('/pengumuman/{id}', [AnnouncementController::class, 'show'])->name('admin.pengumuman.show');

    // Manage User
    Route::get('/admin/usersManage', [UserController::class, 'index'])->name('admin.usersManage');
    Route::post('/admin/usersManage', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/usersManage/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::get('/admin/usersManage/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::delete('/admin/usersManage/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/usersManage/{id}', [UserController::class, 'show'])->name('admin.users.show');

  
});

// --- Dashboard User ---
Route::middleware('auth')->get('/dashboard/user', fn() => view('dashboard/user'))->name('dashboard.user');

// --- Users ---
Route::get('/users', [UserController::class, 'index']);
