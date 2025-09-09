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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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

        // Hitung jumlah transaksi
        $transactionsCount = $transactions->total();
        


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
        $completedCount = Transaction::where('status', 'Completed')->count();
        $pendingCount = Transaction::whereIn('status', ['Pending', 'Verification'])->count();
        $totalTransactions = Transaction::count();

        return view('admin.transaksi', compact(
            'transactions',
            'installments',
            'totalRevenue',
            'transactionsCount',
            'completedCount',
            'pendingCount',
            'totalTransactions'
        ));
    }

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

        return view('admin.transaksi', ['tab' => 'installments'], compact('installments'));
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

    public function detailInstallment($id)
    {
        try {
            $installment = FeePayment::with(['transaction.user'])->findOrFail($id);

            return view('admin.detailInstallment', compact('installment'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Installment not found'
            ], 404);
        }
    }

    public function verify(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $installment = FeePayment::findOrFail($id);
            $transaction = $installment->transaction;

            $action = $request->action;

            if ($action === 'approve') {
                // Ubah status cicilan jadi Completed
                $installment->update([
                    'status' => 'Completed',
                    'paid_at' => now()
                ]);

            } elseif ($action === 'reject') {
                // Ubah status cicilan jadi Failed
                $installment->update([
                    'status' => 'Failed'
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Aksi tidak valid.'
                ], 400);
            }

            // === Hitung ulang total cicilan ===
            $totalCompleted = FeePayment::where('transaction_id', $transaction->id)
                ->where('status', 'Completed')
                ->sum('amount');

            $totalVerification = FeePayment::where('transaction_id', $transaction->id)
                ->where('status', 'Verification')
                ->sum('amount');

            $totalFailed = FeePayment::where('transaction_id', $transaction->id)
                ->where('status', 'Failed')
                ->sum('amount');

            // === Tentukan status transaksi ===
            if ($totalCompleted >= $transaction->amount) {
                // Semua cicilan sudah lunas
                $newTrxStatus = 'Completed';
            } elseif ($totalVerification > 0) {
                // Masih ada cicilan dalam proses verifikasi
                $newTrxStatus = 'Verification';
            } elseif ($totalFailed > 0 && $totalCompleted + $totalVerification < $transaction->amount) {
                // Ada cicilan gagal & belum lunas → anggap Pending
                $newTrxStatus = 'Pending';
            } else {
                // Default (belum lunas, masih jalan)
                $newTrxStatus = 'Pending';
            }

            $transaction->update([
                'status' => $newTrxStatus,
                'paid_at' => ($newTrxStatus === 'Completed') ? now() : null
            ]);

            // Update user status kalau transaksi sudah lunas
            if ($newTrxStatus === 'Completed') {
                $user = $transaction->user;
                if ($user && $user->status_id != 2) {
                    $user->update(['status_id' => 2]); // Paid Student
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cicilan berhasil diverifikasi.',
                'transaction_status' => $newTrxStatus
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Verifikasi cicilan gagal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi cicilan.'
            ], 500);
        }
    }

    public function verifyWithMeeting(Request $request)
    {
        // 👉 Jika tombol Tolak ditekan
        if ($request->has('reject')) {
            $transaction = Transaction::findOrFail($request->transaction_id);

            $transaction->update([
                'status' => 'Failed',
            ]);

            return redirect()->back()->with('success', 'Transaksi berhasil ditolak.');
        }

        // 👉 Kalau Terima, jalankan validasi
        $validationRules = [
            'transaction_id'   => 'required|exists:transactions,id',
            'meeting_date'     => 'required|date',
            'meeting_time'     => 'required',
            'meeting_platform' => 'required|in:google_meet,zoom',
            'meet_link'        => 'required|url',
        ];

        // Tambahan validasi untuk Zoom
        if ($request->meeting_platform === 'zoom') {
            $validationRules['zoom_meeting_id'] = 'required|string';
            $validationRules['zoom_passcode'] = 'required|string';
        }

        $request->validate($validationRules);

        try {
            $transaction = Transaction::with('user')->findOrFail($request->transaction_id);
            $feepayment = FeePayment::where('transaction_id', $transaction->id)->firstOrFail();

            // ✅ Update transaksi
            $transaction->update([
                'status' => 'Completed',
                'paid_at' => now()
            ]);

            // ✅ Update Transaksi Booking
            $feepayment->update([
                'status' => 'Completed',
                'paid_at' => now()
            ]);


            $this->updateUserStatus($transaction);

            // ✅ Tentukan jadwal meeting
            $scheduledAt = Carbon::parse($request->meeting_date . ' ' . $request->meeting_time);

            // ✅ Tentukan link meeting berdasarkan platform
            $meetLink = $request->meet_link;
            
            // Untuk Zoom, kita tetap simpan zoom_meet_link jika ada
            if ($request->meeting_platform === 'zoom' && $request->has('zoom_meet_link')) {
                $meetLink = $request->zoom_meet_link;
            }

            // ✅ Simpan ke tabel meetings
            \DB::table('meetings')->insert([
                'user_id'        => $transaction->user_id,
                'platform'       => $request->meeting_platform,
                'meet_link'      => $meetLink,
                'zoom_meeting_id'=> $request->meeting_platform === 'zoom' ? $request->zoom_meeting_id : null,
                'zoom_passcode'  => $request->meeting_platform === 'zoom' ? $request->zoom_passcode : null,
                'schedule_at'    => $scheduledAt,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // ✅ Update announcement
            $announcement = Announcement::where('type', 'auto booking success')
                ->where('status', 'published')
                ->latest()
                ->first();

            if (!$announcement) {
                return redirect()->back()->with('error', 'Pengumuman auto booking success tidak ditemukan.');
            }

            $announcement->update([
                'meet_link'        => $meetLink,
                'scheduled_at'     => $scheduledAt,
            ]);

            // ✅ Kirim email
            $users = User::where('status_id', 2)->get();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new \App\Mail\MeetingInvitationMail(
                    $user,
                    $announcement->title,
                    $announcement->content,
                    $request->meeting_platform,
                    $meetLink,
                    $scheduledAt,
                    $request->meeting_platform === 'zoom' ? $request->zoom_meeting_id : null,
                    $request->meeting_platform === 'zoom' ? $request->zoom_passcode   : null
                ));
            }

            return redirect()->back()->with('success', 'Transaksi disetujui, meeting tersimpan, pengumuman diperbarui, dan email undangan meeting telah dikirim.');

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

    public function exportTransactions(Request $request)
    {
        try {
            // Ambil query transaksi yang sama dengan UI
            $query = \App\Models\Transaction::with(['user', 'feePayments']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            if ($request->filled('search')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
                });
            }

            if ($request->filled('date_from') && $request->filled('date_to')) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            }

            // ambil semua data (tanpa paginate)
            $transactions = $query->get();

            // buat file Excel (pakai PhpSpreadsheet, sama seperti sebelumnya)
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // buat header
            $headers = ['ID', 'Nama User', 'Email', 'Tipe', 'Jumlah', 'Status', 'Paid At', 'Created At'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col.'1', $header);
                $sheet->getStyle($col.'1')->getFont()->setBold(true);
                $sheet->getColumnDimension($col)->setAutoSize(true);
                $col++;
            }

            // === Styling Header === //
            $headerStyle = [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'], // Biru soft
                ]
            ];
            $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
            $sheet->getRowDimension(1)->setRowHeight(25);

            // Freeze header
            $sheet->freezePane('A2');

            $row = 2;
            foreach ($transactions as $trx) {
                $sheet->setCellValue("A{$row}", $trx->id);
                $sheet->setCellValue("B{$row}", $trx->user->name ?? '-');
                $sheet->setCellValue("C{$row}", $trx->user->email ?? '-');
                $sheet->setCellValue("D{$row}", $trx->type);
                $sheet->setCellValue("E{$row}", (float) $trx->amount);
                $sheet->setCellValue("F{$row}", $trx->status);
                $sheet->setCellValue("G{$row}", $trx->paid_at ? $trx->paid_at->format('d/m/Y H:i:s') : '-');
                $sheet->setCellValue("H{$row}", $trx->created_at ? $trx->created_at->format('d/m/Y H:i:s') : '-');
                $row++;
            }

            // Format Rupiah
            $sheet->getStyle("E2:E".($row-1))
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

            // === Border untuk semua data === //
            $borderStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'AAAAAA'],
                    ]
                ]
            ];
            $sheet->getStyle('A1:H' . ($row - 1))->applyFromArray($borderStyle);

            // Autosize kolom
            foreach (range('A', 'H') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Set judul file
            $filename = 'Data_Transaksi_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            $tempFile = tempnam(sys_get_temp_dir(), $filename);

            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFile);

            return response()->download($tempFile, $filename)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal export data: '.$e->getMessage());
        }
    }

    // ===== FUNGSI FITUR CICILAN =====
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
                } else {
                    // Kalau belum lunas, status tetap "Pending"
                    $payment->transaction->update(['status' => 'Pending']);
                }

                // ✅ Update status user jika masih "Meeting Joined" (3) → jadi "Active" (5)
                if ($payment->transaction->user->status_id == 3) {
                    $payment->transaction->user->update(['status_id' => 5]);
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
        try {
            $query = \App\Models\FeePayment::with('transaction.user');

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->has('date_from') && $request->has('date_to')) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            }

            $installments = $query->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('Your App Name')
                ->setLastModifiedBy('System')
                ->setTitle('Data Installments Report')
                ->setSubject('Installments Export')
                ->setDescription('Laporan data cicilan')
                ->setKeywords('installments export cicilan')
                ->setCategory('Reports');

            // Header configuration
            $headers = [
                'ID Cicilan', 'Nama User', 'Email',
                'ID Transaksi', 'Total Transaksi', 'Tipe Transaksi',
                'Jumlah Cicilan', 'Cicilan ke-', 'Progress (%)',
                'Total Dibayar', 'Status', 'Bukti',
                'Dibayar Pada', 'Dibuat Pada'
            ];

            // Set headers
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $col++;
            }

            // Professional header styling
            $headerRange = 'A1:' . chr(64 + count($headers)) . '1';
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                    'name' => 'Calibri',
                    'color' => ['argb' => 'FFFFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2E5984'] // Professional blue
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['argb' => 'FF2E5984']
                    ]
                ]
            ];
            $sheet->getStyle($headerRange)->applyFromArray($headerStyle);

            // Set column widths for better readability
            $columnWidths = [
                'A' => 12,  // ID Cicilan
                'B' => 20,  // Nama User
                'C' => 25,  // Email
                'D' => 12,  // ID Transaksi
                'E' => 18,  // Total Transaksi
                'F' => 15,  // Tipe Transaksi
                'G' => 16,  // Jumlah Cicilan
                'H' => 12,  // Cicilan ke-
                'I' => 12,  // Progress (%)
                'J' => 18,  // Total Dibayar
                'K' => 14,  // Status
                'L' => 12,  // Bukti
                'M' => 18,  // Dibayar Pada
                'N' => 18   // Dibuat Pada
            ];

            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }

            // Set row height for header
            $sheet->getRowDimension('1')->setRowHeight(25);

            // Fill data with enhanced styling
            $row = 2;
            foreach ($installments as $installment) {
                $transaction = $installment->transaction;
                $user        = $transaction?->user;

                $totalPaid = \App\Models\FeePayment::where('transaction_id', $installment->transaction_id)
                    ->where('status', 'Completed')
                    ->sum('amount');
                $percentage = $transaction && $transaction->amount > 0
                    ? round(($totalPaid / $transaction->amount) * 100, 1)
                    : 0;

                // Fill data
                $sheet->setCellValue('A' . $row, $installment->id);
                $sheet->setCellValue('B' . $row, $user->name ?? 'N/A');
                $sheet->setCellValue('C' . $row, $user->email ?? 'N/A');
                $sheet->setCellValue('D' . $row, $transaction?->id ?? '-');
                $sheet->setCellValue('E' . $row, (float) ($transaction?->amount ?? 0));
                $sheet->setCellValue('F' . $row, ucfirst($transaction?->type ?? '-'));
                $sheet->setCellValue('G' . $row, (float) $installment->amount);
                $sheet->setCellValue('H' . $row, $installment->installment_number ?? '-');
                $sheet->setCellValue('I' . $row, $percentage);
                $sheet->setCellValue('J' . $row, (float) $totalPaid);
                $sheet->setCellValue('K' . $row, $installment->status);
                $sheet->setCellValue('L' . $row, $installment->photo_url ? 'Ada' : 'Tidak Ada');
                $sheet->setCellValue('M' . $row, $installment->paid_at ? $installment->paid_at->format('d/m/Y H:i') : '-');
                $sheet->setCellValue('N' . $row, $installment->created_at ? $installment->created_at->format('d/m/Y H:i') : '-');

                // Row styling with alternating colors
                $rowRange = 'A' . $row . ':' . chr(64 + count($headers)) . $row;
                $rowColor = ($row % 2 == 0) ? 'FFF8F9FA' : 'FFFFFFFF'; // Light gray and white alternating

                $rowStyle = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => $rowColor]
                    ],
                    'font' => [
                        'size' => 10,
                        'name' => 'Calibri'
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => false
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FFE0E0E0']
                        ]
                    ]
                ];
                $sheet->getStyle($rowRange)->applyFromArray($rowStyle);

                // Enhanced status styling with better colors and rounded appearance
                $statusCell = 'K' . $row;
                $statusStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        ]
                    ]
                ];

                switch ($installment->status) {
                    case 'Completed':
                        $statusStyle['fill'] = [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FF28A745'] // Success green
                        ];
                        $statusStyle['font']['color'] = ['argb' => 'FFFFFFFF'];
                        $statusStyle['borders']['allBorders']['color'] = ['argb' => 'FF1E7E34'];
                        break;
                    case 'Pending':
                        $statusStyle['fill'] = [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFFFC107'] // Warning yellow
                        ];
                        $statusStyle['font']['color'] = ['argb' => 'FF212529'];
                        $statusStyle['borders']['allBorders']['color'] = ['argb' => 'FFD39E00'];
                        break;
                    case 'Verification':
                        $statusStyle['fill'] = [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FF17A2B8'] // Info blue
                        ];
                        $statusStyle['font']['color'] = ['argb' => 'FFFFFFFF'];
                        $statusStyle['borders']['allBorders']['color'] = ['argb' => 'FF117A8B'];
                        break;
                    case 'Failed':
                        $statusStyle['fill'] = [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFDC3545'] // Danger red
                        ];
                        $statusStyle['font']['color'] = ['argb' => 'FFFFFFFF'];
                        $statusStyle['borders']['allBorders']['color'] = ['argb' => 'FFC82333'];
                        break;
                    default:
                        $statusStyle['fill'] = [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FF6C757D'] // Secondary gray
                        ];
                        $statusStyle['font']['color'] = ['argb' => 'FFFFFFFF'];
                        $statusStyle['borders']['allBorders']['color'] = ['argb' => 'FF495057'];
                        break;
                }
                
                $sheet->getStyle($statusCell)->applyFromArray($statusStyle);

                // Progress bar visualization in column I
                $progressCell = 'I' . $row;
                if ($percentage > 0) {
                    $progressColor = $percentage >= 100 ? 'FF28A745' : ($percentage >= 50 ? 'FFFFC107' : 'FFDC3545');
                    $sheet->getStyle($progressCell)->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => $progressColor]
                        ],
                        'font' => [
                            'bold' => true,
                            'color' => ['argb' => $percentage >= 50 && $percentage < 100 ? 'FF000000' : 'FFFFFFFF']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                        ]
                    ]);
                }

                $row++;
            }

            // Apply number formatting for currency columns
            $currencyStyle = [
                'numberFormat' => [
                    'formatCode' => '"Rp" #,##0.00_-'
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                ]
            ];

            foreach (['E', 'G', 'J'] as $col) {
                $sheet->getStyle($col . '2:' . $col . ($row - 1))->applyFromArray($currencyStyle);
            }

            // Center align certain columns
            $centerColumns = ['A', 'D', 'H', 'I', 'K', 'L'];
            foreach ($centerColumns as $col) {
                $sheet->getStyle($col . '2:' . $col . ($row - 1))->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }

            // Add freeze panes for header
            $sheet->freezePane('A2');

            // Add auto filter
            $sheet->setAutoFilter('A1:' . chr(64 + count($headers)) . '1');

            // Set print settings
            $sheet->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
                ->setFitToPage(true)
                ->setFitToWidth(1)
                ->setFitToHeight(0);

            // Set margins
            $sheet->getPageMargins()
                ->setTop(0.75)
                ->setRight(0.7)
                ->setLeft(0.7)
                ->setBottom(0.75);

            // Add header and footer for printing
            $sheet->getHeaderFooter()
                ->setOddHeader('&C&B&16Data Installments Report')
                ->setOddFooter('&L&D &T&R&P of &N');

            // Create filename with better naming
            $filename = 'Data_Installments_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            $filePath = storage_path('app/exports/' . $filename);

            // Ensure directory exists
            if (!file_exists(storage_path('app/exports'))) {
                mkdir(storage_path('app/exports'), 0755, true);
            }

            // Save file
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            return response()->download($filePath, $filename)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Export installments gagal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Gagal export cicilan: ' . $e->getMessage());
        }
    }


}