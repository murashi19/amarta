<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminOnly;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UsersController;

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
    
    // Manajemen User
    Route::get('/admin/usersManage', [UsersController::class, 'index'])->name('admin.usersManage');
    
    // Create User Routes - pastikan method yang benar
    Route::get('/admin/createUser', [UsersController::class, 'create'])->name('admin.createUser');
    Route::post('/admin/createUser', [UsersController::class, 'store'])->name('admin.createUser.store');
    
    // Edit User Routes
    Route::get('/admin/{user}/editUser', [UsersController::class, 'edit'])->name('admin.editUser');
    Route::put('/admin/editUser/{user}', [UsersController::class, 'update'])->name('admin.editUser.update');
    
    // Additional user routes
    Route::get('/admin/usersManage/{user}', [UsersController::class, 'show'])->name('admin.usersManage.show');
    Route::delete('/admin/usersManage/{user}', [UsersController::class, 'destroy'])->name('admin.usersManage.destroy');
    
    // API routes untuk AJAX
    Route::get('/admin/users/data', [UsersController::class, 'getData'])->name('admin.users.data');
});

// --- Dashboard User ---
Route::middleware('auth')->get('/dashboard/user', fn() => view('dashboard/user'))->name('dashboard.user');