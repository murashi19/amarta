<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;


class TransactionController extends Controller
{
    use AuthorizesRequests;
     // ======================== BOOKING ========================
    public function showBooking(Transaction $transaction)
    {

        $transactionQuery = Transaction::with('feePayments');
        $this->authorize('view', $transaction);

        if ($transaction->status === 'Pending' && $transaction->expires_at && now()->greaterThan($transaction->expires_at)) {
            $transaction->update(['status' => 'Failed']);
        }

        $paymentMethod = PaymentMethod::where('bank_name', 'MANDIRI')->first();

        $transactions = $transactionQuery->latest()->paginate(15, ['*'], 'transactions_page');

        $transactions->getCollection()->transform(function ($transaction) {
            $transaction->latestProof = $transaction->feePayments()
                ->whereNotNull('photo')
                ->latest()
                ->first();
            return $transaction;
        });


        return view('transaksi.booking', compact('transaction', 'paymentMethod'));
    }

    public function createBooking(Request $request)
    {
        $user = Auth::user();

        if ($user->status_id != 1) {
            return redirect()->back()->with('error', 'Kamu tidak bisa melakukan booking di tahap ini.');
        }

        $existing = Transaction::where('user_id', $user->id)
            ->where('type', 'booking')
            ->whereIn('status', ['Pending', 'Verification'])
            ->first();

        if ($existing) {
            return redirect()->route('transaksi.booking', ['transaction' => $existing->id]);
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'booking',
            'amount' => 500000,
            'status' => 'Pending',
            'description' => 'Pembayaran Booking Kelas',
            'expires_at' => now()->addMinutes(5),
        ]);

        return redirect()->route('transaksi.booking', ['transaction' => $transaction->id])
            ->with('success', 'Transaksi booking berhasil dibuat.');
    }

    // ======================== UPLOAD BUKTI UMUM ========================
    public function uploadProof(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Akses tidak diizinkan.'], 403);
        }

        if (!in_array($trx->status, ['Pending', 'Verification'])) {
            return response()->json(['success' => false, 'message' => 'Transaksi ini tidak bisa diubah.'], 400);
        }

        if ($trx->expires_at && now()->greaterThan($trx->expires_at)) {
            $trx->update(['status' => 'Failed']);
            return response()->json(['success' => false, 'message' => 'Waktu pembayaran sudah habis. Transaksi kadaluarsa.'], 400);
        }

        $request->validate([
            'proof' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $file = $request->file('proof');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('proofs', $fileName, 'public');

        FeePayment::create([
            'transaction_id' => $trx->id,
            'amount' => $trx->amount,
            'payment_method' => 'transfer',
            'paid_at' => now(),
            'status' => 'Verification',
            'photo' => $fileName, // hanya filename
        ]);

        $trx->update(['status' => 'Verification']);

        return redirect()->route('dashboard.users')
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }



    // ======================== PROGRAM KELAS (DP & CICILAN) ========================
    public function createProgramKelas()
    {
        $user = Auth::user();

        $booking = Transaction::where('user_id', $user->id)
            ->where('type', 'booking')
            ->where('status', 'Completed')
            ->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Kamu harus menyelesaikan pembayaran Booking Class terlebih dahulu.');
        }

        $existing = Transaction::where('user_id', $user->id)
            ->where('type', 'dp')
            ->whereIn('status', ['Pending', 'Verification', 'Completed'])
            ->first();

        if ($existing) {
            return redirect()->route('transaksi.programKelas', ['id' => $existing->id]);
        }

        $amount = Fee::where('type', 'dp')->value('amount') ?? 7000000;

        $trx = Transaction::create([
            'user_id' => $user->id,
            'type' => 'dp',
            'amount' => $amount,
            'status' => 'Pending',
            'description' => 'Pembayaran Program Kelas (DP)',
            'expires_at' => now()->addDays(30),
        ]);

        return redirect()->route('transaksi.programKelas', ['id' => $trx->id])
            ->with('success', 'Pembayaran Program Kelas berhasil dibuat.');
    }

    public function showProgramKelas($id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $installments = FeePayment::where('transaction_id', $trx->id)->orderBy('created_at', 'desc')->get();
        $totalPaid = $installments->where('status', 'Completed')->sum('amount');
        $hasPending = $installments->whereIn('status', ['Pending', 'Verification'])->isNotEmpty();
        $isDisabled = $hasPending || $trx->status === 'Completed';

        $paymentMethods = PaymentMethod::all()->groupBy('type');

        return view('transaksi.programKelas', compact('trx','installments','totalPaid','paymentMethods','isDisabled','hasPending'));
    }

    public function storeInstallment(Request $request, $id)
    {
        DB::beginTransaction();
        $proofFileName = null;

        try {
            $trx = Transaction::findOrFail($id);

            if ($trx->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Akses tidak diizinkan.'], 403);
            }

            if ($trx->status === 'Completed') {
                return response()->json(['success' => false, 'message' => 'Transaksi sudah lunas.'], 400);
            }

            if ($trx->expires_at && Carbon::parse($trx->expires_at)->isPast()) {
                return response()->json(['success' => false, 'message' => 'Transaksi sudah expired.'], 400);
            }

            if ($trx->type !== 'dp') {
                return response()->json(['success' => false, 'message' => 'Transaksi ini tidak dapat dibayar dengan cicilan.'], 400);
            }

            $totalPaid = FeePayment::where('transaction_id', $trx->id)->whereIn('status', ['Completed', 'Verification'])->sum('amount');
            $remaining = $trx->amount - $totalPaid;

            $request->validate([
                'amount' => ['required','numeric','min:100000',"max:$remaining"],
                'payment_method' => 'required|string|in:transfer_bank,ewallet,cash',
                'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'selected_method' => 'nullable|string|max:50',
                'payment_notes' => 'nullable|string|max:500',
            ]);

            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $proofFileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('payment_proofs', $proofFileName, 'public');
            }

            $referenceNumber = 'INS-' . strtoupper(uniqid()) . '-' . $trx->id;
            $nextInstallmentNumber = FeePayment::where('transaction_id', $trx->id)->count() + 1;

            $installment = FeePayment::create([
                'transaction_id' => $trx->id,
                'installment_number' => $nextInstallmentNumber,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'selected_method' => $request->selected_method,
                'photo' => $proofFileName, // konsisten filename
                'notes' => $request->payment_notes,
                'reference_number' => $referenceNumber,
                'paid_at' => now(),
                'expires_at' => now()->addHours(24),
                'status' => 'Verification',
            ]);

            
            
            DB::commit();
        
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran cicilan berhasil dikirim dan menunggu verifikasi admin.',
                'data' => [
                    'installment_id' => $installment->id,
                    'reference_number' => $referenceNumber,
                    'installment_number' => $nextInstallmentNumber,
                    'amount' => $request->amount,
                    'total_paid' => $totalPaid + $request->amount,
                    'remaining' => $trx->amount - ($totalPaid + $request->amount),
                    'status' => 'Verification'
                ]
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            if ($proofFileName) {
                Storage::disk('public')->delete("payment_proofs/$proofFileName");
            }
            return response()->json(['success' => false,'message' => 'Data tidak valid.','errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($proofFileName) {
                Storage::disk('public')->delete("payment_proofs/$proofFileName");
            }
            return response()->json(['success' => false,'message' => 'Terjadi kesalahan: '.$e->getMessage()], 500);
        }
    }

    /**
     * Get payment method details
     */
    public function getPaymentMethodDetails($type)
    {
        try {
            if ($type === 'mandiri') {
                // Ambil data Mandiri (ID 2 berdasarkan SQL dump Anda)
                $paymentMethod = PaymentMethod::where('bank_name', 'MANDIRI')->first();
            } elseif ($type === 'cash') {
                // Ambil data Cash (ID 9)
                $paymentMethod = PaymentMethod::where('type', 'cash')->first();
            } else {
                // Default ke Mandiri
                $paymentMethod = PaymentMethod::where('bank_name', 'MANDIRI')->first();
            }

            if (!$paymentMethod) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment method not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'bank_name' => $paymentMethod->bank_name,
                    'account_number' => $paymentMethod->account_number,
                    'account_name' => $paymentMethod->account_name,
                    'type' => $paymentMethod->type
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving payment method details'
            ], 500);
        }
    }
    /**
     * Cancel payment (for expired or user cancellation)
     */
    public function cancelPayment($installmentId)
    {
        try {
            $installment = FeePayment::findOrFail($installmentId);
            
            if ($installment->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses tidak diizinkan'
                ], 403);
            }

            if ($installment->status !== 'Verification') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran tidak dapat dibatalkan'
                ], 400);
            }

            DB::beginTransaction();

            // Delete the uploaded proof file
            if ($installment->proof && Storage::disk('public')->exists($installment->proof)) {
                Storage::disk('public')->delete($installment->proof);
            }

            // Delete installment record
            $installment->delete();

            // Update transaction status if no pending verification
            $transaction = $installment->transaction;
            $pendingPayments = FeePayment::where('transaction_id', $transaction->id)
                ->where('status', 'Verification')
                ->count();

            if ($pendingPayments === 0) {
                $totalCompleted = FeePayment::where('transaction_id', $transaction->id)
                    ->where('status', 'Completed')
                    ->sum('amount');

                if ($totalCompleted >= $transaction->amount) {
                    $transaction->update(['status' => 'Completed']);
                } else {
                    $transaction->update(['status' => 'Pending']);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dibatalkan'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Payment cancellation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan pembayaran'
            ], 500);
        }
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

    /**
     * Tampilkan halaman pembayaran single payment (Pemantapan / Pemberangkatan)
     */
    public function showSinglePayment($type)
    {
        // 🔒 Cek tipe transaksi
        if (!in_array($type, ['pemantapan', 'pemberangkatan'])) {
            abort(404, 'Tipe transaksi tidak valid.');
        }

        // Ambil transaksi terbaru milik user dengan tipe tersebut
        $trx = Transaction::where('user_id', Auth::id())
            ->where('type', $type)
            ->latest()
            ->firstOrFail();

        $paymentMethods = PaymentMethod::all()->groupBy('type');
        $bank = PaymentMethod::where('id', 2)->firstOrFail();

        // 🔒 Pastikan status valid
        if (!in_array($trx->status, ['Pending', 'Verification', 'Completed'])) {
            abort(403, 'Status transaksi tidak valid.');
        }

        // 🔒 Cek kadaluarsa
        if ($trx->expires_at && now()->greaterThan($trx->expires_at)) {
            $trx->update(['status' => 'Failed']);
            abort(403, 'Waktu pembayaran sudah habis. Transaksi kadaluarsa.');
        }

        // 🔒 Cek jika sudah lunas
        if ($trx->status === 'Completed') {
            abort(403, 'Transaksi ini sudah lunas.');
        }

        // 🔒 Cek jika ada bukti pembayaran
        if ($trx->proof) {
            abort(403, 'Transaksi ini sudah memiliki bukti pembayaran.');
        }

        $isDisabled = $trx->status !== 'Pending' && $trx->status !== 'Verification';

        return view('transaksi.payment', compact(
            'trx',
            'paymentMethods',
            'bank',
            'isDisabled'
        ));
    }


    // ======================== SINGLE PAYMENT ========================
    public function uploadSinglePaymentProof(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->user_id !== Auth::id()) {
            return response()->json(['success' => false,'message' => 'Akses tidak diizinkan.'], 403);
        }

        if (!in_array($trx->type, ['pemantapan', 'pemberangkatan'])) {
            return response()->json(['success' => false,'message' => 'Transaksi ini bukan pembayaran Pemantapan/Pemberangkatan.'], 400);
        }

        if (!in_array($trx->status, ['Pending', 'Verification'])) {
            return response()->json(['success' => false,'message' => 'Transaksi ini tidak bisa diubah.'], 400);
        }

        if ($trx->expires_at && now()->greaterThan($trx->expires_at)) {
            $trx->update(['status' => 'Failed']);
            return response()->json(['success' => false,'message' => 'Waktu pembayaran sudah habis.'], 400);
        }

        $request->validate([
            'proof' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            'payment_method' => 'required|string|in:bank_transfer,ewallet,cash',
            'selected_method' => 'nullable|string|max:50',
            'payment_notes'   => 'nullable|string|max:500',
        ]);

        $file = $request->file('proof');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('proofs', $fileName, 'public');

        FeePayment::create([
            'transaction_id'  => $trx->id,
            'amount'          => $trx->amount,
            'payment_method'  => $request->payment_method,
            'selected_method' => $request->selected_method,
            'photo'           => $fileName, // konsisten filename
            'notes'           => $request->payment_notes,
            'reference_number'=> strtoupper($trx->type) . '-' . uniqid(),
            'paid_at'         => now(),
            'status'          => 'Verification',
        ]);

        $trx->update(['status' => 'Verification']);

        return redirect()->route('transaksi.showSinglePayment', ['id' => $trx->id])
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }



}

