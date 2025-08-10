<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\OwnsTransaction;
use App\Http\Middleware\CheckFinanceAccess;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ManageTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FinanceController;


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
Route::post('/transactions', [TransactionController::class, 'store']);

// --- Dashboard Admin ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
    
    // Pengumuman khusus admin
    Route::get('/admin/pengumuman', [AnnouncementController::class, 'index'])->name('admin.pengumuman');
    Route::post('/admin/pengumuman', [AnnouncementController::class, 'store'])->name('admin.pengumuman.store');
    Route::put('/admin/pengumuman/{id}', [AnnouncementController::class, 'update'])->name('admin.pengumuman.update');
    Route::get('/admin/pengumuman/{id}/edit', [AnnouncementController::class, 'edit'])->name('admin.pengumuman.edit');
    Route::delete('/admin/pengumuman/{id}', [AnnouncementController::class, 'destroy'])->name('admin.pengumuman.destroy');
    Route::get('/admin/pengumuman/{id}/show', [AnnouncementController::class, 'show'])->name('admin.pengumuman.show');

    
    // Manajemen User
    Route::get('/admin/usersManage', [UsersController::class, 'index'])->name('admin.usersManage');
    Route::get('/admin/createUser', [UsersController::class, 'create'])->name('admin.createUser');  // Tampilan tambah
    Route::post('/admin/createUser', [UsersController::class, 'store'])->name('admin.createUser.store'); // Proses tambah
    Route::get('/admin/{user}/editUser', [UsersController::class, 'edit'])->name('admin.editUser'); // Tampilan edit
    Route::put('/admin/editUser/{user}', [UsersController::class, 'update'])->name('admin.editUser.update'); // Proses edit
    Route::get('/admin/{user}/userDetail', [UsersController::class, 'show'])->name('admin.usersManage');
    Route::delete('/admin/usersManage/{user}', [UsersController::class, 'destroy'])->name('admin.usersManage.destroy');

    
    // Additional user routes
    Route::get('/admin/userDetail/{user}', [UsersController::class, 'show'])->name('admin.userDetail');
    Route::delete('/admin/usersManage/{user}', [UsersController::class, 'deleteUser'])->name('admin.usersManage.deleteUser');
    
    // API routes untuk AJAX
    Route::get('/admin/users/data', [UsersController::class, 'getData'])->name('admin.users.data');

    // Manajemen Transaksi
    Route::get('/admin/transaksi', [ManageTransactionController::class, 'index'])->name('admin.transaksi');
    Route::get('/admin/detailTransaksi/{id}', [ManageTransactionController::class, 'detail'])->name('admin.detailTransaksi');
    Route::post('/admin/transaksi/{id}/verify', [ManageTransactionController::class, 'verify'])->name('admin.transaksi.verify');
    Route::post('/admin/transaksi/verifyWithMeeting', [ManageTransactionController::class, 'verifyWithMeeting'])->name('admin.transaksi.verifyWithMeeting');
    Route::post('/admin/transaksi/{id}/updateStatus', [ManageTransactionController::class, 'updateStatus'])->name('admin.transaksi.updateStatus');
    Route::delete('/admin/transaksi/{id}', [ManageTransactionController::class, 'destroy'])->name('admin.transaksi.destroy');
    Route::get('/admin/transaksi/export', [ManageTransactionController::class, 'export'])->name('admin.transaksi.export');

    // === CICILAN ===
    Route::get('/cicilan', [ManageTransactionController::class, 'listInstallments'])->name('cicilan');
    Route::post('/installments/{id}/verify', [ManageTransactionController::class, 'verifyInstallment'])->name('admin.installments.verify');
    Route::get('/installments/export', [ManageTransactionController::class, 'exportInstallments'])->name('admin.transaksi.installments.export');

    // API routes untuk AJAX
    Route::get('/admin/transaksi/data', [ManageTransactionController::class, 'getData'])->name('admin.transaksi.data');
});

// --- Dashboard User ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/users', [AnnouncementController::class, 'AnnountmentsUser'])->name('dashboard.users');

    // Profile
    Route::get('/users/profile', [UsersController::class, 'profile'])->name('users.profile');
    Route::get('/users/editProfile', [UsersController::class, 'editProfile'])->name('users.editProfile');
    Route::put('/users/editProfile', [UsersController::class, 'updateProfile'])->name('users.editProfile.updateProfile');

    // Keuangan
    Route::middleware(['auth', 'CheckFinanceAccess'])->group(function () {
        Route::get('/users/keuangan', [FinanceController::class, 'index'])->name('users.keuangan');
    });

    // Transaksi

    // Transaksi Booking
    Route::get('/transaksi/booking/{id}', [TransactionController::class, 'showBooking'])
    ->middleware('ownsTransaction')
    ->name('transaksi.booking');

    Route::post('/transaksi/booking', [TransactionController::class, 'createBooking'])->name('transaksi.booking.createBooking');
    Route::put('/transaksi/booking/{id}/upload', [TransactionController::class, 'uploadProof'])->name('transaksi.booking.upload');

    // Transaksi Program Kelas
    Route::get('/transaksi/programKelas/{id}', [TransactionController::class, 'showProgramKelas'])->name('transaksi.programKelas');
    Route::get('/transaksi/programKelas', [TransactionController::class, 'createProgramKelas'])->name('transaksi.programKelas.createProgramKelas');
    Route::post('/transaksi/{id}/programKelas', [TransactionController::class, 'storeInstallment'])->name('transaksi.programKelas.storeInstallment');
    Route::get('/transaksi/programKelas/status/{id}', [TransactionController::class, 'checkStatus'])->name('transaksi.programKelas.checkStatus');


    

});

