<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\ClassProgram;
use App\Models\UserClass;
use App\Models\ProgramFee;
use App\Models\Fee;
use App\Models\PaymentSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // <-- tambahin
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index()
    {
        try {
            // Bersihkan transaksi yang user-nya sudah tidak ada
            Transaction::whereDoesntHave('user')->delete();

            $user = auth()->user();
            Log::info("FinanceController@index - User login", ['user_id' => $user->id]);
            $userStatusId = $user->status_id ?? 1;
            Log::info("FinanceController@index - User status", ['status_id' => $userStatusId]);


            $userClass = $user->userClasses()
                ->with(['classProgram.programFee'])
                ->latest()
                ->first();

            if (!$userClass) {
                Log::warning("FinanceController@index - User belum punya class", ['user_id' => $user->id]);
            }

            $fees = Fee::all()->keyBy('type');
            Log::info("FinanceController@index - Fee data", ['fees' => $fees->pluck('amount','type')]);

            $biayaBooking       = $fees['booking']->amount ?? 500000;
            $biayaDp            = $fees['kelas_bahasa']->amount ?? 7000000;
            $biayaPemantapan    = $fees['pemantapan']->amount ?? 20000000;
            $biayaPemberangkatan= $fees['pemberangkatan']->amount ?? 35000000;

            // Booking
            $bookingTransaction = $user->transactions()
                ->where('type', 'booking')
                ->latest()
                ->first();

            if (!$bookingTransaction) {
                $bookingTransaction = Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'booking',
                    'status' => 'Pending',
                    'amount' => $biayaBooking,
                ]);
            }

            // DP
            $dpTransaction = $user->transactions()
                ->where('type', 'dp')
                ->latest()
                ->first();

            if (!$dpTransaction) {
                $dpTransaction = Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'dp',
                    'status' => 'Pending',
                    'amount' => $biayaDp,
                ]);
            }
            
            // Pemantapan
            $pemantapanTransaction = $user->transactions()
                ->where('type', 'pemantapan')
                ->latest()
                ->first();

            if (!$pemantapanTransaction) {
                if ($userStatusId === 6) {
                    $pemantapanTransaction = Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'pemantapan',
                    'status' => 'Pending',
                    'amount' => $biayaPemantapan,
                    ]);
                }
                
            }

            // Pemberangkatan
            $pemberangkatanTransaction = $user->transactions()
                ->where('type', 'pemberangkatan')
                ->latest()
                ->first();

            if (!$pemberangkatanTransaction) {
                if ($userStatusId === 7) {
                    $pemberangkatanTransaction = Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'pemberangkatan',
                    'status' => 'Pending',
                    'amount' => $biayaPemberangkatan,
                    ]);
                }
            }

            // Cek status pembayaran
            $bookingPaid = $bookingTransaction && $bookingTransaction->status === 'Completed';
            $dpPaid = $dpTransaction && $dpTransaction->status === 'Completed';
            $pemantapanPaid = $pemantapanTransaction && $pemantapanTransaction->status === 'Completed';
            $pemberangkatanPaid = $pemberangkatanTransaction && $pemberangkatanTransaction->status === 'Completed';

            Log::info("FinanceController@index - Payment status", [
                'booking' => $bookingTransaction?->status,
                'dp' => $dpTransaction?->status,
                'pemantapan' => $pemantapanTransaction?->status,
                'pemberangkatan' => $pemberangkatanTransaction?->status,
            ]);

            // Hitung total biaya sesuai status
            $totalBiaya = 0;
            if ($userStatusId == 1) {
                $totalBiaya = $biayaBooking;
            } elseif ($userStatusId == 3 || $userStatusId == 5) {
                $totalBiaya = $biayaBooking + $biayaDp;
            } elseif ($userStatusId == 6) {
                $totalBiaya = $biayaBooking + $biayaDp + $biayaPemantapan;
            } elseif ($userStatusId == 7) {
                $totalBiaya = $biayaBooking + $biayaDp + $biayaPemantapan + $biayaPemberangkatan;
            }

            if (!$userClass || !$userClass->classProgram) {
                Log::warning("FinanceController@index - User belum terdaftar di program", ['user_id' => $user->id]);
                return view('users.keuangan', compact(
                    'user',
                    'userClass',
                    'totalBiaya',
                    'biayaBooking',
                    'biayaDp',
                    'biayaPemantapan',
                    'biayaPemberangkatan',
                    'bookingTransaction',
                    'dpTransaction',
                    'pemantapanTransaction',
                    'pemberangkatanTransaction',
                    'bookingPaid',
                    'dpPaid',
                    'pemantapanPaid',
                    'pemberangkatanPaid'
                ))->with('error', 'Anda belum terdaftar di program manapun.');
            }

            return view('users.keuangan', compact(
                'user',
                'userClass',
                'totalBiaya',
                'biayaBooking',
                'biayaDp',
                'biayaPemantapan',
                'biayaPemberangkatan',
                'bookingTransaction',
                'dpTransaction',
                'pemantapanTransaction',
                'pemberangkatanTransaction',
                'bookingPaid',
                'dpPaid',
                'pemantapanPaid',
                'pemberangkatanPaid'
            ));
        } catch (\Exception $e) {
            Log::error("FinanceController@index error", [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan di sistem. Silakan coba lagi.');
        }
    }
}
