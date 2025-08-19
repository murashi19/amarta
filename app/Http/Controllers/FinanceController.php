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
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $userClass = $user->userClasses()
            ->with(['classProgram.programFee'])
            ->latest()
            ->first();

        $fees = Fee::all()->keyBy('type');

        $biayaBooking = $fees['booking']->amount ?? 500000;
        $biayaDp = $fees['kelas_bahasa']->amount ?? 7000000;
        $biayaPemantapan = $fees['pemantapan']->amount ?? 20000000;
        $biayaPemberangkatan = $fees['pemberangkatan']->amount ?? 35000000;

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
            $pemantapanTransaction = Transaction::create([
                'user_id' => $user->id,
                'type' => 'pemantapan',
                'status' => 'Pending',
                'amount' => $biayaPemantapan,
            ]);
        }

        // Pemberangkatan
        $pemberangkatanTransaction = $user->transactions()
            ->where('type', 'pemberangkatan')
            ->latest()
            ->first();

        if (!$pemberangkatanTransaction) {
            $pemberangkatanTransaction = Transaction::create([
                'user_id' => $user->id,
                'type' => 'pemberangkatan',
                'status' => 'Pending',
                'amount' => $biayaPemberangkatan,
            ]);
        }


        $pemantapanPaid = $pemantapanTransaction && $pemantapanTransaction->status === 'Completed';
        $pemberangkatanPaid = $pemberangkatanTransaction && $pemberangkatanTransaction->status === 'Completed';

        $userStatus = $user->status->name ?? null;

        $totalBiaya = ($userStatus === 'Departure Paid')
            ? $biayaBooking + $biayaDp + $biayaPemantapan + $biayaPemberangkatan
            : $biayaBooking + $biayaDp;

        // Jika user belum punya kelas, beri error
        if (!$userClass || !$userClass->classProgram) {
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
            'pemantapanPaid',
            'pemberangkatanPaid'
        ));
    }

}
