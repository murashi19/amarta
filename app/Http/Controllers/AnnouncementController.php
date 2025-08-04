<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    // --- Pengumuman ---
    public function index()
    {
        $announcements = Announcement::orderBy('id', 'asc')->get();
        return view('admin.pengumuman', compact('announcements'));
    }

    // --- Tambah Pengumuman ---
    public function store(Request $request)
    {
        // Debug log untuk CREATE
        \Log::info('🔍 CREATE REQUEST DATA:', [
            'all_request' => $request->all(),
            'has_payment_button_raw' => $request->input('has_payment_button')
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'target_audience' => 'required|string',
            'meet_link' => 'nullable|url',
            'has_payment_button' => 'nullable|string',
            'scheduled_date' => 'nullable|date',
            'scheduled_time' => 'nullable',
        ]);

        // Handle checkbox untuk CREATE
        $isCreateMode = $isNewAnnouncement ?? true; // Atur ini sesuai logika buat/edit

        if ($request->has('has_payment_button')) {
            $validated['has_payment_button'] = true;
        } else {
            $validated['has_payment_button'] = $isCreateMode ? true : false;
        }

        $announcement = Announcement::create($validated);

        \Log::info('📝 CREATE RESULT:', [
            'has_payment_button_in_db' => $announcement->has_payment_button,
            'created_data' => $announcement->toArray()
        ]);

        // Check if request expects JSON (AJAX)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    // --- Edit Pengumuman ---
    public function edit($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            return response()->json($announcement);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Pengumuman tidak ditemukan'
            ], 404);
        }
    }

    // --- Update Pengumuman ---
    public function update(Request $request, $id)
    {
        try {
            // Debug log untuk melihat data yang masuk
            \Log::info('🔍 UPDATE REQUEST DATA:', [
                'all_request' => $request->all(),
                'has_payment_button_raw' => $request->input('has_payment_button'),
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type')
            ]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'type' => 'required|string',
                'status' => 'required|string',
                'priority' => 'required|string',
                'target_audience' => 'required|string',
                'meet_link' => 'nullable|url',
                'has_payment_button' => 'nullable|string', // Terima sebagai string
                'scheduled_date' => 'nullable|date',
                'scheduled_time' => 'nullable',
            ]);

            // PERBAIKAN UTAMA: Handle checkbox dengan eksplisit
            $checkboxValue = $request->input('has_payment_button');
            
            // Convert ke boolean dengan benar
            if ($checkboxValue === '1' || $checkboxValue === 1 || $checkboxValue === true || $checkboxValue === 'true') {
                $validated['has_payment_button'] = true;
            } else {
                $validated['has_payment_button'] = false;
            }

            // Debug log detail
            \Log::info('🔧 CHECKBOX PROCESSING:', [
                'raw_value' => $checkboxValue,
                'processed_value' => $validated['has_payment_button'],
                'type_of_raw' => gettype($checkboxValue),
                'type_of_processed' => gettype($validated['has_payment_button'])
            ]);

            $announcement = Announcement::findOrFail($id);
            
            // Update dengan data yang sudah diproses
            $updated = $announcement->update($validated);
            
            // Log hasil update
            \Log::info('📝 UPDATE RESULT:', [
                'update_success' => $updated,
                'has_payment_button_in_db' => $announcement->fresh()->has_payment_button,
                'all_data_in_db' => $announcement->fresh()->toArray()
            ]);

            $announcement = $announcement->fresh(); // Refresh data dari DB

            // Check if request expects JSON (AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengumuman berhasil diperbarui!',
                    'data' => $announcement
                ]);
            }

            return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui pengumuman'
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat memperbarui pengumuman');
        }
    }

    // --- Hapus Pengumuman ---
    public function destroy($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->delete();

            return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengumuman')->with('error', 'Gagal menghapus pengumuman.');
        }
    }

    // --- Lihat Detail Pengumuman ---
    public function show($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            
            // If AJAX request, return JSON
            if (request()->expectsJson()) {
                return response()->json($announcement);
            }
            
            return view('admin.pengumuman-detail', compact('announcement'));
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Pengumuman tidak ditemukan'], 404);
            }
            return redirect()->route('admin.pengumuman')->with('error', 'Pengumuman tidak ditemukan.');
        }
    }

    // --- Fungsi tambahan untuk view pengumuman (jika diperlukan) ---
    public function view($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            
            // Increment views count
            $announcement->increment('views');
            
            return response()->json([
                'success' => true,
                'data' => $announcement
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan'
            ], 404);
        }
    }
}