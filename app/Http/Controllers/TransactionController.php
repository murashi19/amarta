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
    // Fungsi untuk membuat transaksi booking
    public function showBooking(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        // Tandai transaksi kadaluarsa jika lewat waktu
        if ($transaction->status === 'Pending' && $transaction->expires_at && now()->greaterThan($transaction->expires_at)) {
            $transaction->update(['status' => 'Failed']);
        }

        return view('transaksi.booking', compact('transaction'));
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
            return redirect()->route('transaksi.booking', ['transaction' => $existing->id]);

        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'booking',
            'amount' => 500000,
            'status' => 'Pending',
            'description' => 'Pembayaran Booking Kelas',
            'expires_at' => now()->addminutes(5), // Waktu kadaluarsa 24 jam
        ]);

        return redirect()->route('transaksi.booking', ['transaction' => $transaction->id])
            ->with('success', 'Transaksi booking berhasil dibuat.');

    }

    // Fungsi untuk upload bukti pembayaran
    public function uploadProof(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);

        // Cek kepemilikan
        if ($trx->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Akses tidak diizinkan.'
            ], 403);
        }

        // Pastikan status valid
        if (!in_array($trx->status, ['Pending', 'Verification'])) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi ini tidak bisa diubah.'
            ], 400);
        }

        // Cek kadaluarsa
        if ($trx->expires_at && now()->greaterThan($trx->expires_at)) {
            $trx->update(['status' => 'Failed']);
            return response()->json([
                'success' => false,
                'message' => 'Waktu pembayaran sudah habis. Transaksi kadaluarsa.'
            ], 400);
        }

        // Validasi file
        $request->validate([
            'proof' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $path = $request->file('proof')->store('proofs', 'public');

        // Simpan pembayaran
        FeePayment::create([
            'transaction_id' => $trx->id,
            'amount' => $trx->amount,
            'payment_method' => 'transfer',
            'paid_at' => now(),
            'status' => 'verification',
            'photo' => $path,
        ]);

        // Update status transaksi
        $trx->update(['status' => 'verification']);

        return redirect()->route('dashboard.users')
    ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');

    }



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
        // Redirect ke halaman pembayaran
        return redirect()->route('transaksi.programKelas', ['id' => $trx->id])
            ->with('success', 'Pembayaran Program Kelas berhasil dibuat.');
    }

    /**
     * Show program kelas payment page
     */
    public function showProgramKelas($id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Get all installments for this transaction
        $installments = FeePayment::where('transaction_id', $trx->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate total paid amount
        $totalPaid = $installments->whereIn('status', ['Completed', 'Verification'])->sum('amount');

        // Get payment methods for display
        $paymentMethods = PaymentMethod::all()->groupBy('type');

        return view('transaksi.programKelas', compact('trx', 'installments', 'totalPaid', 'paymentMethods'));
    }

    /**
     * Store installment payment
     */
    public function storeInstallment(Request $request, $id)
    {
        DB::beginTransaction();
        $proofPath = null;

        try {
            $trx = Transaction::findOrFail($id);

            // 1. Authorization & Transaction State Checks
            if ($trx->user_id !== Auth::id()) {
                \Log::warning('Unauthorized access attempt to store installment.', [
                    'transaction_id' => $id,
                    'user_id' => Auth::id()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Akses tidak diizinkan.'
                ], 403);
            }

            if ($trx->status === 'Completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi sudah lunas.'
                ], 400);
            }

            if ($trx->expires_at && Carbon::parse($trx->expires_at)->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi sudah expired.'
                ], 400);
            }
            
            // Periksa apakah ini adalah transaksi yang bisa dicicil (misal: dp)
            if ($trx->type !== 'dp') {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi ini tidak dapat dibayar dengan cicilan.'
                ], 400);
            }

            // 2. Calculate Remaining Amount
            $totalPaid = FeePayment::where('transaction_id', $trx->id)
                ->whereIn('status', ['Completed', 'Verification'])
                ->sum('amount');
            $remaining = $trx->amount - $totalPaid;

            // 3. Input Validation
            $request->validate([
                'amount' => ['required', 'numeric', 'min:100000', "max:$remaining"],
                'payment_method' => 'required|string|in:transfer_bank,ewallet,cash',
                'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'selected_method' => 'nullable|string|max:50',
                'payment_notes' => 'nullable|string|max:500',
            ], [
                'amount.max' => 'Jumlah pembayaran melebihi sisa tagihan.',
                'amount.min' => 'Minimal pembayaran adalah Rp 100.000.',
                'payment_proof.required' => 'Bukti pembayaran harus diupload.',
                'payment_proof.mimes' => 'Format file harus JPG, PNG, atau PDF.',
                'payment_proof.max' => 'Ukuran file maksimal 5MB.',
            ]);

            // 4. File Upload
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $proofPath = $file->storeAs('payment_proofs', $fileName, 'public');

                if (!Storage::disk('public')->exists($proofPath)) {
                    throw new \Exception('Gagal mengupload file bukti pembayaran.');
                }
            }

            // 5. Create Installment Record
            $referenceNumber = 'INS-' . strtoupper(uniqid()) . '-' . $trx->id;
            $nextInstallmentNumber = FeePayment::where('transaction_id', $trx->id)->count() + 1;

            $installment = FeePayment::create([
                'transaction_id' => $trx->id,
                'installment_number' => $nextInstallmentNumber,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'selected_method' => $request->selected_method,
                'photo' => $proofPath,
                'notes' => $request->payment_notes,
                'reference_number' => $referenceNumber,
                'paid_at' => now(),
                'expires_at' => now()->addHours(24),
                'status' => 'Verification',
            ]);

            // 6. Update Transaction & User Status
            $newTotalPaid = FeePayment::where('transaction_id', $trx->id)
                ->whereIn('status', ['Completed', 'Verification'])
                ->sum('amount');
            $isFullyPaid = ($newTotalPaid >= $trx->amount);
            $newTrxStatus = $isFullyPaid ? 'Completed' : 'Verification';

            $trx->update(['status' => $newTrxStatus]);

            $user = $trx->user;
            // Perbarui status user jika memenuhi syarat
            // Disesuaikan dengan alur bisnis Anda: dari 'Meeting Joined' (id 3) ke 'Active' (id 5)
            if ($user && $user->status_id == 3) {
                $user->update(['status_id' => 5]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran cicilan berhasil dikirim dan menunggu verifikasi admin.',
                'data' => [
                    'installment_id' => $installment->id,
                    'reference_number' => $referenceNumber,
                    'amount' => $request->amount,
                    'total_paid' => $newTotalPaid,
                    'remaining' => $trx->amount - $newTotalPaid,
                    'is_fully_paid' => $isFullyPaid,
                    'status' => $newTrxStatus
                ]
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            if (isset($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }
            \Log::error('Validation error on installment payment.', [
                'transaction_id' => $id,
                'user_id' => Auth::id(),
                'request_data' => $request->except(['payment_proof']),
                'validation_errors' => $e->errors()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }
            \Log::error('Payment upload error: ' . $e->getMessage(), [
                'transaction_id' => $id,
                'user_id' => Auth::id(),
                'request_data' => $request->except(['payment_proof'])
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get payment method details
     */
    public function getPaymentMethodDetails(Request $request)
    {
        $type = $request->get('type');
        $method = $request->get('method');

        if ($type === 'transfer_bank' && $method) {
            $paymentMethod = PaymentMethod::getByBankName($method);
            
            if ($paymentMethod) {
                return response()->json([
                    'success' => true,
                    'data' => $paymentMethod
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Metode pembayaran tidak ditemukan'
        ], 404);
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

}

