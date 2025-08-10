<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Status;
use App\Models\UserClass;
use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{

    // Fungsi untuk membuat transaksi booking
    public function showBooking($id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke transaksi ini.');
        }

        // Tandai transaksi kadaluarsa jika lewat waktu
        if ($trx->status === 'Pending' && $trx->expires_at && now()->greaterThan($trx->expires_at)) {
            $trx->update(['status' => 'Failed']);
        }

        return view('transaksi.booking', compact('trx'));
    }

    public function createBooking(Request $request)
    {
        $user = Auth::user();

        if ($user->status_id != 1) {
            return redirect()->back()->with('error', 'Kamu tidak bisa melakukan booking di tahap ini.');
        }

        $existing = Transaction::where('user_id', $user->id)
            ->where('type', 'booking')
            ->where('status', 'Pending', 'Verification')
            ->first();

        if ($existing) {
            return redirect()->route('transaksi.booking', ['id' => $existing->id]);
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'booking',
            'amount' => 500000,
            'status' => 'Pending',
            'description' => 'Pembayaran Booking Kelas',
            'expires_at' => now()->addminutes(5), // Waktu kadaluarsa 24 jam
        ]);

        return redirect()->route('transaksi.booking', ['id' => $transaction->id]);
    }

    // Fungsi untuk upload bukti pembayaran
    public function uploadProof(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);

        // Cek kepemilikan transaksi
        if ($trx->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Pastikan status transaksi masih pending atau verification
        if ($trx->status !== 'Pending' && $trx->status !== 'Verification') {
            return back()->with('error', 'Transaksi ini tidak bisa diubah.');
        }

        // Cek apakah sudah kadaluarsa
        if ($trx->expires_at && now()->greaterThan($trx->expires_at)) {
            $trx->update(['status' => 'Failed']);
            return back()->with('error', 'Waktu pembayaran sudah habis. Transaksi kadaluarsa.');
        }

        // Validasi file bukti
        $request->validate([
            'proof' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $path = $request->file('proof')->store('proofs', 'public');

        // Simpan ke fee_payments
        FeePayment::create([
            'transaction_id' => $trx->id,
            'user_id' => Auth::id(),
            'amount' => $trx->amount,
            'payment_method' => 'transfer',
            'paid_at' => now(),
            'status' => 'verification',
            'photo' => $path,
        ]);

        // Update status transaksi
        $trx->update(['status' => 'verification']);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }


    public function showProgramKelas($id)
    {
        $trx = Transaction::with('user')->findOrFail($id);

        if ($trx->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses ke transaksi ini.');
        }

        // Hitung total cicilan yang sudah dibayar
        $totalPaid = FeePayment::where('transaction_id', $trx->id)
            ->where('status', 'Completed')
            ->sum('amount');

        // Ambil histori cicilan
        $installments = FeePayment::where('transaction_id', $trx->id)
            ->latest()
            ->get();

        return view('transaksi.programKelas', compact('trx', 'installments', 'totalPaid'));
    }

    /**
     * Membuat transaksi Program Kelas (DP)
     */
    public function createProgramKelas()
    {
        $user = Auth::user();

        // Cek status booking
        $booking = Transaction::where('user_id', $user->id)
            ->where('type', 'booking')
            ->where('status', 'Completed')
            ->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Kamu harus menyelesaikan pembayaran Booking Class terlebih dahulu.');
        }

        // Jika sudah punya transaksi DP, langsung redirect
        $existing = Transaction::where('user_id', $user->id)
            ->where('type', 'dp')
            ->whereIn('status', ['Pending', 'Verification', 'Completed'])
            ->first();

        if ($existing) {
            return redirect()->route('transaksi.programKelas', ['id' => $existing->id]);
        }

        // Nominal DP default 7 juta
        $amount = Fee::where('type', 'dp')->value('amount') ?? 7000000;

        $trx = Transaction::create([
            'user_id' => $user->id,
            'type' => 'dp',
            'amount' => $amount,
            'status' => 'Pending',
            'description' => 'Pembayaran Program Kelas (DP)',
            'expires_at' => now()->addDays(30),
        ]);

        return redirect()->route('transaksi.programKelas', ['id' => $trx->id]);
    }

    /**
     * Menyimpan pembayaran cicilan
     */
    public function storeInstallment(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        if ($trx->status === 'Completed') {
            return back()->with('error', 'Transaksi sudah lunas.');
        }

        // Hitung sisa tagihan
        $totalPaid = FeePayment::where('transaction_id', $trx->id)
            ->whereIn('status', ['Completed', 'Verification'])
            ->sum('amount');

        $remaining = $trx->amount - $totalPaid;

        $request->validate([
            'amount' => ['required', 'numeric', 'min:400000', "max:$remaining"],
            'payment_method' => 'required|string|max:50',
        ], [
            'amount.max' => 'Jumlah pembayaran melebihi sisa tagihan.',
            'amount.min' => 'Minimal pembayaran adalah Rp 400.000.',
        ]);

        // Simpan cicilan (status awal Verification)
        FeePayment::create([
            'transaction_id' => $trx->id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'proof' => $request->hasFile('proof') ? $request->file('proof')->store('proofs', 'public') : null,
            'paid_at' => now(),
            'status' => 'Verification',
        ]);

        // Update status transaksi menjadi "Verification"
        $trx->update(['status' => 'Verification']);

        // Ubah status user menjadi Active (id=5) jika masih Meeting Joined (id=3)
        $user = $trx->user;
        if ($user && $user->status_id == 3) {
            $user->update(['status_id' => 5]);
        }

        return back()->with('success', 'Pembayaran cicilan berhasil dikirim, menunggu verifikasi admin.');
    }

    public function checkStatus($id)
    {
            $trx = Transaction::findOrFail($id);

        if ($trx->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => $trx->status
        ]);

    }

}

