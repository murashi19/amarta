<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('document_type',['KTP','KK','Akte Kelahiran','Paspor','Foto Terbaru','SKCK','Ijazah','Transkrip Nilai','CV','Sertifikat Pelatihan','Sertifikat Bahasa','Surat Keterangan Sehat','Hasil Tes Kesehatan','Kartu Vaksinasi','Surat Izin Orang Tua','Surat Rekomendasi Sekolah','Surat Perjanjian LPK','Lainnya']);
            $table->text('file_path');
            $table->enum('status',['Pending','Approved','Rejected'])->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_documents');
    }
};
