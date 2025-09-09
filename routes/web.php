<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\OwnsTransaction;
use App\Http\Middleware\CheckFinanceAccess;
use App\Http\Middleware\OwnsPaymentOrder;
use App\Http\Middleware\EnsureUserIsVerified;
// use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserAnnouncementController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ManageTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\LanguageController;

// --- Landing Page ---

Route::get('/', fn() => view('home'));
Route::get('/program', fn() => view('program'));
Route::get('/about', fn() => view('about'));
Route::get('/contact', fn() => view('contact'));
// Route::post('/contact', [FormController::class, 'send'])->name('form.send');
Route::get('/daftar', fn() => view('daftar'));
Route::get('change/{lang}', [LanguageController::class, 'change'])->name('lang.change');
Route::get('/register', fn() => view('auth/register'));
Route::get('/verify', fn() => view('auth/verify'));


// --- Auth Routes ---
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rute untuk halaman verifikasi OTP
Route::get('/verify-otp/{id}', [AuthController::class, 'showVerify'])->name('verifyOtp');
Route::post('/verify-otp', [AuthController::class, 'processVerification'])->name('verifyOtp.process');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resendOtp');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/transactions', [TransactionController::class, 'store']);

// --- Dashboard Admin ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
    
    // Pengumuman khusus admin
    Route::get('/admin/pengumuman', [AnnouncementController::class, 'index'])->name('admin.pengumuman');
    Route::post('/admin/pengumuman/filter', [AnnouncementController::class, 'filter'])->name('admin.pengumuman.filter');
    Route::post('/admin/pengumuman', [AnnouncementController::class, 'store'])->name('admin.pengumuman.store');
    Route::put('/admin/pengumuman/{id}', [AnnouncementController::class, 'update'])->name('admin.pengumuman.update');
    Route::get('/admin/pengumuman/{id}/edit', [AnnouncementController::class, 'edit'])->name('admin.pengumuman.edit');
    Route::delete('/admin/pengumuman/{id}', [AnnouncementController::class, 'destroy'])->name('admin.pengumuman.destroy');
    Route::get('/admin/pengumuman/{id}/show', [AnnouncementController::class, 'show'])
    ->name('admin.pengumuman.show');

    // Manajemen User
    Route::get('/admin/usersManage', [UsersController::class, 'index'])->name('admin.usersManage');
    Route::post('/admin/usersManage/filter', [UserController::class, 'filter'])->name('admin.usersManage.filter');
    Route::get('/admin/createUser', [UsersController::class, 'create'])->name('admin.createUser');  // Tampilan tambah
    Route::post('/admin/createUser', [UsersController::class, 'store'])->name('admin.createUser.store'); // Proses tambah
    Route::get('/admin/{user}/editUser', [UsersController::class, 'edit'])->name('admin.editUser'); // Tampilan edit
    Route::put('/admin/editUser/{user}', [UsersController::class, 'update'])->name('admin.editUser.update'); // Proses edit
    Route::get('/admin/{user}/userDetail', [UsersController::class, 'show'])->name('admin.usersManage.show');
    Route::delete('/admin/usersManage/{user}', [UsersController::class, 'destroy'])->name('admin.usersManage.destroy');

    
    // Additional user routes
    Route::get('/admin/userDetail/{user}', [UsersController::class, 'show'])->name('admin.userDetail');
    Route::delete('/admin/usersManage/{user}', [UsersController::class, 'deleteUser'])->name('admin.usersManage.deleteUser');
    Route::put('/admin/users/{id}/update-status', [UserController::class, 'updateStatus'])
     ->name('admin.users.updateStatus');


    // Profile
    Route::get('/admin/profile', [UsersController::class, 'adminProfile'])->name('admin.profile');
    Route::get('/admin/editProfile', [UsersController::class, 'editAdminProfile'])->name('admin.editProfile');
    Route::put('/admin/updateProfile', [UsersController::class, 'updateAdminProfile'])->name('admin.updateProfile');
    Route::post('/change-password', [UsersController::class, 'updatePassword'])->name('password.update');

    
    // API routes untuk AJAX
    Route::get('/admin/users/data', [UsersController::class, 'getData'])->name('admin.users.data');

    // Manajemen Transaksi
    Route::get('/admin/transaksi', [ManageTransactionController::class, 'index'])->name('admin.transaksi');
    Route::get('/admin/detailTransaksi/{id}', [ManageTransactionController::class, 'detail'])->name('admin.detailTransaksi');
    Route::post('/admin/transaksi/{id}/verify', [ManageTransactionController::class, 'verify'])->name('admin.transaksi.verify');
    Route::post('/admin/transaksi/verifyWithMeeting', [ManageTransactionController::class, 'verifyWithMeeting'])->name('admin.transaksi.verifyWithMeeting');
    Route::post('/admin/transaksi/{id}/updateStatus', [ManageTransactionController::class, 'updateStatus'])->name('admin.transaksi.updateStatus');
    Route::delete('/admin/transaksi/{id}', [ManageTransactionController::class, 'destroy'])->name('admin.transaksi.destroy');
    Route::get('/admin/transaksi/export', [ManageTransactionController::class, 'exportTransactions'])
    ->name('admin.transaksi.export');

    // === CICILAN ===
    Route::get('/cicilan', [ManageTransactionController::class, 'listInstallments'])->name('cicilan');
    Route::post('/installments/{id}/verify', [ManageTransactionController::class, 'verifyInstallment'])->name('admin.installments.verify');
    Route::get('/installments/{id}', [ManageTransactionController::class, 'detailInstallment'])->name('admin.installments.detail');
    Route::get('/admin/transaksi/installments/export', [ManageTransactionController::class, 'exportInstallments'])
    ->name('admin.installments.export');


    // API routes untuk AJAX
    Route::get('/admin/transaksi/data', [ManageTransactionController::class, 'getData'])->name('admin.transaksi.data');
});

// --- Dashboard User ---
Route::middleware(['auth', 'verifikasi'])->group(function () {
    Route::get('/dashboard/users', [AnnouncementController::class, 'AnnountmentsUser'])
    ->name('dashboard.users');
    Route::post('/meetings/{id}/attendance', [AnnouncementController::class, 'markAttendance'])
        ->name('meetings.attendance');

    // Profile
    Route::get('/users/profile', [UsersController::class, 'profile'])->name('users.profile');
    Route::get('/users/editProfile', [UsersController::class, 'editProfile'])->name('users.editProfile');
    Route::put('/users/editProfile', [UsersController::class, 'updateProfile'])->name('users.editProfile.updateProfile');
    Route::post('/change-password', [UsersController::class, 'updatePassword'])->name('password.update');

    // Keuangan
    Route::middleware(['auth', 'CheckFinanceAccess'])->group(function () {
        Route::get('/users/keuangan', [FinanceController::class, 'index'])->name('users.keuangan');
    });

    // Transaksi Booking
   Route::get('/transaksi/booking/{transaction}', [TransactionController::class, 'showBooking'])
    ->middleware(['auth', 'ownsTransaction'])
    ->name('transaksi.booking');


    Route::post('/transaksi/booking', [TransactionController::class, 'createBooking'])->name('transaksi.booking.createBooking');
    Route::put('/transaksi/booking/{transaction}/upload', [TransactionController::class, 'uploadProof'])->name('transaksi.booking.upload');

    // Program Kelas routes
    Route::get('/keuangan/program-kelas/create', [TransactionController::class, 'createProgramKelas'])
        ->name('transaksi.programKelas.create');
    
    Route::get('/transaksi/program-kelas/{id}', [TransactionController::class, 'showProgramKelas'])
        ->name('transaksi.programKelas');
    Route::get('/payment-method-details/{type}', [TransactionController::class, 'getPaymentMethodDetails']);

    Route::post('/transaksi/program-kelas/{id}/cicilan', [TransactionController::class, 'storeInstallment'])
        ->name('transaksi.programKelas.storeInstallment');

    Route::get('/transaksi/payment/type/{type}', [TransactionController::class, 'showSinglePayment'])
        ->name('transaksi.showSinglePayment');
    Route::post('/transaksi/payment/{id}/upload-proof', [TransactionController::class, 'uploadSinglePaymentProof'])->name('transaksi.uploadSinglePaymentProof');
});

