<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
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
use Carbon\Carbon;

class ManageTransactionController extends Controller
{
    public function index(Request $request)
    {
        // Handle transactions
        $transactionQuery = Transaction::with(['user', 'feePayments']);


        // Pencarian transaksi
        if ($request->filled('search')) {
            $search = $request->search;
            $transactionQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        // Filter berdasarkan tipe transaksi
        if ($request->filled('type')) {
            $transactionQuery->where('type', $request->type);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $transactionQuery->where('status', $request->status);
        }

        $transactions = $transactionQuery->latest()->paginate(15, ['*'], 'transactions_page');

        // Filter transaksi setelah diambil
        $transactions->getCollection()->transform(function ($transaction) {
            if ($transaction->status === 'Verification') {
                $totalPaid = $transaction->feePayments->sum('amount');
                $isFullyPaid = $totalPaid >= $transaction->amount;
                if (!$isFullyPaid) {
                    // Jika belum lunas, ubah statusnya agar tombol verifikasi tidak muncul
                    $transaction->status = 'Pending'; 
                }
            }
            return $transaction;
        });
        // Handle installments
        $installmentQuery = FeePayment::with(['transaction.user'])
            ->whereHas('transaction', function ($q) {
                $q->where('type', 'dp'); // hanya program kelas
            });

        // Pencarian cicilan
        if ($request->filled('search_installment')) {
            $search = $request->search_installment;
            $installmentQuery->whereHas('transaction.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status cicilan
        if ($request->filled('status_installment')) {
            $installmentQuery->where('status', $request->status_installment);
        }

        $installments = $installmentQuery->latest()->paginate(15, ['*'], 'installments_page');

        $totalRevenue = Transaction::where('status', 'Completed')->sum('amount');

        return view('admin.transaksi', compact('transactions', 'installments', 'totalRevenue'));
    }

    public function detail($id)
    {
        try {
            $transaction = Transaction::with(['user'])->findOrFail($id);

            return view('admin.detailTransaksi', compact('transaction'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }
    }

    public function verify(Request $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            if (!in_array($transaction->status, ['Pending', 'verification'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak dalam status yang dapat diverifikasi'
                ], 400);
            }

            $action = $request->action;

            if ($action === 'approve') {
                // Ubah status transaksi
                $transaction->update([
                    'status' => 'Completed',
                    'paid_at' => now()
                ]);

                // Update user status jadi Paid Student (status_id = 2)
                $user = $transaction->user;
                $user->status_id = 2;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil disetujui dan status user diperbarui.'
                ]);
            } elseif ($action === 'reject') {
                $transaction->update(['status' => 'Failed']);

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi ditolak.'
                ]);
            } elseif ($action === 'verify') {
                $transaction->update(['status' => 'verification']);

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi ditandai untuk verifikasi manual.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Aksi tidak valid.'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Verifikasi transaksi gagal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi transaksi.'
            ], 500);
        }
    }

    public function verifyWithMeeting(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required',
            'meet_link' => 'required|url',
        ]);

        try {
            $transaction = Transaction::with('user')->findOrFail($request->transaction_id);

            if ($transaction->status !== 'Pending' && $transaction->status !== 'Verification') {
                return redirect()->back()->with('error', 'Transaksi tidak dalam status Pending atau Verification.');
            }

            // ✅ Update transaksi
            $transaction->update([
                'status' => 'Completed',
                'paid_at' => now()
            ]);

            $this->updateUserStatus($transaction);

            // ✅ Update announcement
            $announcement = Announcement::where('type', 'auto booking success')
                ->where('status', 'published')
                ->latest()
                ->first();

            if (!$announcement) {
                return redirect()->back()->with('error', 'Pengumuman auto booking success tidak ditemukan.');
            }

            $scheduledAt = Carbon::parse($request->meeting_date . ' ' . $request->meeting_time);

            $announcement->update([
                'meet_link' => $request->meet_link,
                'scheduled_at' => $scheduledAt,
            ]);

            // ✅ Kirim email ke semua user dengan status_id = 2 (Booking Paid)
            $users = User::where('status_id', 2)->get();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new \App\Mail\MeetingInvitationMail(
                    $user,
                    $announcement->title,
                    $announcement->content,
                    $request->meet_link,
                    $scheduledAt
                ));
            }

            return redirect()->back()->with('success', 'Transaksi disetujui, pengumuman diperbarui, dan email undangan meeting telah dikirim.');

        } catch (\Exception $e) {
            \Log::error('Gagal verifikasi dengan meeting: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyetujui transaksi.');
        }
    }

    private function updateUserStatus($transaction)
    {
        try {
            if (!$transaction->relationLoaded('user')) {
                $transaction->load('user');
            }

            $user = $transaction->user;

            if (!$user) {
                Log::warning("Transaksi #{$transaction->id} tidak memiliki user");
                return;
            }

            if ($transaction->status !== 'Completed') {
                Log::info("Transaksi #{$transaction->id} belum selesai");
                return;
            }

            switch ($transaction->type) {
                case 'booking':
                    if ($user->status_id == 1) {
                        $user->status_id = 2;
                        $user->save();
                        Log::info("User #{$user->id} status diperbarui ke Booking Paid");
                    }
                    break;

                case 'dp':
                    if ($user->status_id == 3) {
                        $user->status_id = 4;
                        $user->save();
                        Log::info("User #{$user->id} status diperbarui ke DP Paid");
                    }
                    break;

                case 'pemantapan':
                    if ($user->status_id == 4) {
                        $user->status_id = 5; // Active
                        $user->save();
                        Log::info("User #{$user->id} status diperbarui ke Active");
                    }
                    break;

                case 'pemberangkatan':
                    if ($user->status_id == 5) {
                        $user->status_id = 6; // Departure Paid
                        $user->save();
                        Log::info("User #{$user->id} status diperbarui ke Departure Paid");
                    }
                    break;

                default:
                    Log::warning("Tipe transaksi tidak dikenali: {$transaction->type}");
            }

        } catch (\Exception $e) {
            Log::error("Gagal memperbarui status user", [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:Pending,Completed,Failed,Verification',
            ]);

            $transaction = Transaction::with('user')->findOrFail($id);
            $oldStatus = $transaction->status;
            $newStatus = $validated['status'];

            if ($oldStatus === $newStatus) {
                return $this->respond($request, true, 'Status tidak berubah', $transaction);
            }

            $updateData = ['status' => $newStatus];
            $message = '';

            if ($newStatus === 'Completed') {
                $updateData['paid_at'] = now();
                $message = 'Transaksi diselesaikan';
            } elseif (in_array($newStatus, ['Failed', 'Pending', 'Verification'])) {
                $updateData['paid_at'] = null;
                $message = 'Status transaksi diubah ke ' . $newStatus;
            }

            $transaction->update($updateData);

            if ($newStatus === 'Completed') {
                $transaction->refresh();
                $this->updateUserStatus($transaction);
            }

            Log::info("Status transaksi diperbarui", [
                'transaction_id' => $transaction->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'updated_by' => auth()->user()->id ?? 'system'
            ]);

            return $this->respond($request, true, $message, $transaction);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->respond($request, false, 'Transaksi tidak ditemukan', null, 404);
        } catch (\Exception $e) {
            Log::error('Gagal update status transaksi: ' . $e->getMessage());
            return $this->respond($request, false, 'Terjadi kesalahan saat mengubah status transaksi', null, 500);
        }
    }

    private function respond(Request $request, $success, $message, $transaction = null, $statusCode = 200)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => $success,
                'message' => $message,
                'transaction_id' => $transaction?->id,
                'new_status' => $transaction?->status,
                'paid_at' => $transaction?->paid_at?->toISOString(),
            ], $statusCode);
        }

        return redirect()->back()->with($success ? 'success' : 'error', $message);
    }

    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            // Simpan log sebelum hapus
            Log::info("Transaksi dihapus", [
                'id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'deleted_by' => auth()->user()->id ?? null,
            ]);

            $transaction->delete();

            return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi.');
        }
    }

    public function export(Request $request)
    {
        $query = Transaction::with(['user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->get();

        $filename = 'transactions_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'User Name',
                'User Email',
                'Type',
                'Amount',
                'Status',
                'Paid At',
                'Created At'
            ]);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->user->name ?? 'N/A',
                    $transaction->user->email ?? 'N/A',
                    ucfirst($transaction->type),
                    $transaction->amount,
                    ucfirst($transaction->status),
                    $transaction->paid_at ? $transaction->paid_at->format('Y-m-d H:i:s') : 'N/A',
                    $transaction->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ===== FUNGSI FITUR CICILAN =====

    // Menampilkan daftar cicilan
    public function listInstallments(Request $request)
    {
        $query = FeePayment::with(['transaction.user'])
            ->whereHas('transaction', function ($q) {
                $q->where('type', 'dp'); // hanya program kelas
            });

        // Pencarian
        if ($request->filled('search_installment')) {
            $search = $request->search_installment;
            $query->whereHas('transaction.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status_installment')) {
            $query->where('status', $request->status_installment);
        }

        $installments = $query->latest()->paginate(15);

        return view('admin.cicilanProgramKelas', compact('installments'));
    }

    public function verifyInstallment(Request $request, $id)
    {
        try {
            $payment = FeePayment::with('transaction.user')->findOrFail($id);

            if (!in_array($payment->status, ['Verification', 'Pending'])) {
                return redirect()->back()->with('error', 'Cicilan ini tidak dalam status verifikasi.');
            }

            if ($request->action === 'approve') {
                $payment->update([
                    'status' => 'Completed',
                    'paid_at' => now()
                ]);

                // Hitung ulang total yang sudah dibayar
                $totalPaid = FeePayment::where('transaction_id', $payment->transaction_id)
                    ->where('status', 'Completed')
                    ->sum('amount');

                // Jika lunas, update transaksi
                if ($totalPaid >= $payment->transaction->amount) {
                    $payment->transaction->update([
                        'status' => 'Completed',
                        'paid_at' => now()
                    ]);
                    $this->updateUserStatus($payment->transaction);
                } else {
                    // Kalau belum lunas, status tetap "Pending"
                    $payment->transaction->update(['status' => 'Pending']);
                }

                Log::info("Cicilan disetujui", [
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                    'amount' => $payment->amount,
                    'total_paid' => $totalPaid,
                    'approved_by' => auth()->user()->id ?? 'system'
                ]);

                return redirect()->back()->with('success', 'Cicilan berhasil disetujui.');
            }

            if ($request->action === 'reject') {
                $payment->update(['status' => 'Failed']);

                Log::info("Cicilan ditolak", [
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                    'amount' => $payment->amount,
                    'rejected_by' => auth()->user()->id ?? 'system'
                ]);

                return redirect()->back()->with('success', 'Cicilan ditolak.');
            }

            return redirect()->back()->with('error', 'Aksi tidak valid.');

        } catch (\Exception $e) {
            Log::error('Gagal memverifikasi cicilan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memverifikasi cicilan.');
        }
    }

    public function exportInstallments(Request $request)
    {
        $query = FeePayment::with(['transaction.user'])
            ->whereHas('transaction', function ($q) {
                $q->where('type', 'dp');
            });

        if ($request->filled('search_installment')) {
            $search = $request->search_installment;
            $query->whereHas('transaction.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_installment')) {
            $query->where('status', $request->status_installment);
        }

        $installments = $query->latest()->get();

        $filename = 'installments_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($installments) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID Payment',
                'Transaction ID',
                'User Name',
                'User Email',
                'Installment Number',
                'Amount',
                'Status',
                'Paid At',
                'Created At',
                'Transaction Amount',
                'Progress'
            ]);

            foreach ($installments as $installment) {
                $totalPaid = FeePayment::where('transaction_id', $installment->transaction_id)
                    ->where('status', 'Completed')
                    ->sum('amount');
                
                $progress = $installment->transaction->amount > 0 ? 
                    ($totalPaid / $installment->transaction->amount) * 100 : 0;

                fputcsv($file, [
                    $installment->id,
                    $installment->transaction_id,
                    $installment->transaction->user->name ?? 'N/A',
                    $installment->transaction->user->email ?? 'N/A',
                    $installment->installment_number ?? 'N/A',
                    $installment->amount,
                    ucfirst($installment->status),
                    $installment->paid_at ? $installment->paid_at->format('Y-m-d H:i:s') : 'N/A',
                    $installment->created_at->format('Y-m-d H:i:s'),
                    $installment->transaction->amount,
                    number_format($progress, 2) . '%'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}