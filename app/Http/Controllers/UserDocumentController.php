<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    /**
     * Tampilkan daftar dokumen user (sudah/belum upload).
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua dokumen milik user
        $documents = UserDocument::where('user_id', $user->id)->get();

        // Daftar dokumen yang diwajibkan
        $requiredDocuments = [
            'KTP',
            'KK',
            'Akte Kelahiran',
            'Paspor',
            'Foto Terbaru',
            'SKCK',
            'Ijazah',
            'Transkrip Nilai',
            'CV',
            'Sertifikat Pelatihan',
            'Sertifikat Bahasa',
            'Surat Keterangan Sehat',
            'Hasil Tes Kesehatan',
            'Kartu Vaksinasi',
            'Surat Izin Orang Tua',
            'Surat Rekomendasi Sekolah',
            'Surat Perjanjian LPK',
        ];

        return view('user.documents.index', compact('documents', 'requiredDocuments'));
    }

    /**
     * Upload dokumen baru atau update jika sudah ada.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048', // jpg/png/pdf max 2MB
        ]);

        $user = Auth::user();

        // Simpan file ke storage/app/public/documents
        $path = $request->file('file')->store('documents', 'public');

        // Cek apakah user sudah pernah upload dokumen ini
        $document = UserDocument::where('user_id', $user->id)
            ->where('document_type', $request->document_type)
            ->first();

        if ($document) {
            // Hapus file lama
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $document->update([
                'file_path' => $path,
                'status' => 'Pending', // reset status agar diverifikasi ulang
            ]);
        } else {
            UserDocument::create([
                'user_id' => $user->id,
                'document_type' => $request->document_type,
                'file_path' => $path,
                'status' => 'Pending',
            ]);
        }

        return back()->with('success', 'Dokumen berhasil diupload!');
    }
}
