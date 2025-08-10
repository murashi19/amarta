@extends('layouts.dashboardAdmin')

@section('title', 'Pengumuman')

@section('content')
<!-- Main Content -->
<div class="col-md-12 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-bullhorn me-2"></i> Manajemen Pengumuman</h2>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-stats bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $totalAnnouncements ?? 5 }}</h3>
                            <p class="mb-0">Total Pengumuman</p>
                        </div>
                        <div>
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $publishedCount ?? 3 }}</h3>
                            <p class="mb-0">Terbit</p>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $draftCount ?? 2 }}</h3>
                            <p class="mb-0">Draft</p>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $scheduledCount ?? 0 }}</h3>
                            <p class="mb-0">Terjadwal</p>
                        </div>
                        <div>
                            <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="mt-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <!-- Filter Status -->
                    <div class="col-lg-3 col-md-6">
                        <label for="filterStatus" class="form-label">Status</label>
                        <select class="form-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="published">Terbit</option>
                            <option value="draft">Draft</option>
                            <option value="scheduled">Terjadwal</option>
                        </select>
                    </div>

                    <!-- Filter Type -->
                    <div class="col-lg-3 col-md-6">
                        <label for="filterType" class="form-label">Jenis</label>
                        <select class="form-select" id="filterType">
                            <option value="">Semua Jenis</option>
                            <option value="auto welcome">Otomatis - Welcome</option>
                            <option value="auto booking success">Otomatis - Booking Berhasil</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="col-lg-4 col-md-8">
                        <label for="searchAnnouncement" class="form-label">Pencarian</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            placeholder="Cari pengumuman..." 
                            id="searchAnnouncement"
                        >
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button 
                                class="btn btn-outline-primary flex-fill" 
                                onclick="filterAnnouncements()"
                                title="Cari"
                            >
                                <i class="fas fa-search"></i>
                            </button>
                            <button 
                                class="btn btn-primary flex-fill" 
                                data-bs-toggle="modal" 
                                data-bs-target="#announcementModal"
                                title="Buat Pengumuman Baru"
                            >
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('delete_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('delete_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <table class="table table-striped table-hover" id="announcementsTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="3%">#</th>
                            <th width="25%">Judul</th>
                            <th width="15%">Jenis</th>
                            <th width="10%">Status</th>
                            <th width="10%">Prioritas</th>
                            <th width="15%">Target Audiens</th>
                            <th width="10%">Tanggal</th>
                            <th width="4%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($announcements as $index => $announcement)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $announcement->title }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($announcement->content, 100) }}</small>
                                        @if($announcement->has_payment_button)
                                            <br>
                                            <span class="badge bg-primary mt-1"><i class="fas fa-credit-card me-1"></i> Ada Button Bayar</span>
                                        @endif
                                        @if($announcement->meet_link)
                                            <br>
                                            <span class="badge bg-success mt-1"><i class="fas fa-video me-1"></i> Ada Link Meet</span>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="badge bg-info text-white">{{ $announcement->type }}</span></td>
                                <td>
                                    <span class="badge {{ $announcement->status === 'published' ? 'bg-success' : ($announcement->status === 'scheduled' ? 'bg-info' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($announcement->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $announcement->priority === 'high' ? 'bg-danger' : ($announcement->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                                        Prioritas {{ ucfirst($announcement->priority) }}
                                    </span>
                                </td>
                                <td><i class="fas fa-users me-1"></i> {{ $announcement->target_audience }}</td>
                                <td><small>{{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}</small></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="viewAnnouncement({{ $announcement->id }})">
                                                    <i class="fas fa-eye me-2"></i> Lihat
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="editAnnouncement({{ $announcement->id }})">
                                                    <i class="fas fa-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDelete({{ $announcement->id }}, '{{ $announcement->title }}')">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada pengumuman</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form for Delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Form Pengumuman (Create) -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalLabel">
                    <i class="fas fa-plus me-2"></i> Buat Pengumuman Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="announcementForm" action="{{ route('admin.pengumuman.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="_method" value="POST">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <label for="title" class="form-label">Judul Pengumuman</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label for="priority" class="form-label">Prioritas</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="low">Rendah</option>
                                <option value="medium" selected>Sedang</option>
                                <option value="high">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Jenis Pengumuman</label>
                            <select class="form-select" id="type" name="type" onchange="toggleAutoFields()">
                                <option value="manual">Manual</option>
                                <option value="auto welcome">Otomatis - Welcome</option>
                                <option value="auto booking success">Otomatis - Booking Berhasil</option>
                                <option value="auto dp request">Otomatis - DP Request</option>
                                <option value="auto dp success">Otomatis - DP Berhasil</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="target_audience" class="form-label">Target Audiens</label>
                            <select class="form-select" id="target_audience" name="target_audience">
                                <option value="all students">Semua Siswa</option>
                                <option value="new registrants">Pendaftar Baru</option>
                                <option value="paid students">Siswa yang Sudah Bayar Booking</option>
                                <option value="meeting joined">Siswa yang Sudah Join Meeting</option>
                                <option value="dp paid">Siswa yang Sudah Bayar DP</option>
                                <option value="active students">Siswa Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" onchange="toggleAutoFields()">
                                <option value="draft">Draft</option>
                                <option value="published">Terbit</option>
                                <option value="scheduled">Terjadwal</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="content" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>

                    <!-- Fields untuk pengumuman otomatis -->
                    <div id="paymentButtonField" class="mt-3" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="has_payment_button" name="has_payment_button" value="1">
                            <label class="form-check-label" for="has_payment_button">
                                Tampilkan Button Pembayaran
                            </label>
                        </div>
                    </div>

                    <div id="meetLinkField" class="mt-3" style="display: none;">
                        <label for="meet_link" class="form-label">Link Google Meet</label>
                        <input type="url" class="form-control" id="meet_link" name="meet_link" placeholder="https://meet.google.com/...">
                    </div>

                    <div id="scheduledDateField" class="mt-3" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="scheduled_date" class="form-label">Tanggal Terbit</label>
                                <input type="date" class="form-control" id="scheduled_date" name="scheduled_date">
                            </div>
                            <div class="col-md-6">
                                <label for="scheduled_time" class="form-label">Jam Terbit</label>
                                <input type="time" class="form-control" id="scheduled_time" name="scheduled_time">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Edit Pengumuman -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnnouncementModalLabel">
                    <i class="fas fa-edit me-2"></i> Edit Pengumuman
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAnnouncementForm" action="{{ route('admin.pengumuman.update', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <label for="editTitle" class="form-label">Judul Pengumuman</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label for="editPriority" class="form-label">Prioritas</label>
                            <select class="form-select" id="editPriority" name="priority">
                                <option value="low">Rendah</option>
                                <option value="medium">Sedang</option>
                                <option value="high">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="editType" class="form-label">Jenis Pengumuman</label>
                            <select class="form-select" id="editType" name="type" onchange="toggleEditAutoFields()">
                                <option value="manual">Manual</option>
                                <option value="auto welcome">Otomatis - Welcome</option>
                                <option value="auto booking success">Otomatis - Booking Berhasil</option>
                                <option value="auto dp request">Otomatis - DP Request</option>
                                <option value="auto dp success">Otomatis - DP Berhasil</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="editTargetAudience" class="form-label">Target Audiens</label>
                            <select class="form-select" id="editTargetAudience" name="target_audience">
                                <option value="all students">Semua Siswa</option>
                                <option value="new registrants">Pendaftar Baru</option>
                                <option value="paid students">Siswa yang Sudah Bayar Booking</option>
                                <option value="meeting joined">Siswa yang Sudah Join Meeting</option>
                                <option value="dp paid">Siswa yang Sudah Bayar DP</option>
                                <option value="active students">Siswa Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" onchange="toggleEditAutoFields()">
                                <option value="draft">Draft</option>
                                <option value="published">Terbit</option>
                                <option value="scheduled">Terjadwal</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="editContent" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" id="editContent" name="content" rows="5" required></textarea>
                    </div>

                    <!-- Fields untuk pengumuman otomatis -->
                    <div id="editPaymentButtonField" class="mt-3" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editHasPaymentButton" name="has_payment_button">
                            <label class="form-check-label" for="editHasPaymentButton">
                                Tampilkan Button Pembayaran
                            </label>
                        </div>
                    </div>

                    <div id="editMeetLinkField" class="mt-3" style="display: none;">
                        <label for="editMeetLink" class="form-label">Link Google Meet</label>
                        <input type="url" class="form-control" id="editMeetLink" name="meet_link" placeholder="https://meet.google.com/...">
                    </div>

                    <div id="editScheduledDateField" class="mt-3" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="editScheduledDate" class="form-label">Tanggal Terbit</label>
                                <input type="date" class="form-control" id="editScheduledDate" name="scheduled_date">
                            </div>
                            <div class="col-md-6">
                                <label for="editScheduledTime" class="form-label">Jam Terbit</label>
                                <input type="time" class="form-control" id="editScheduledTime" name="scheduled_time">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check me-2"></i>Update Pengumuman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pengumuman -->
<div class="modal fade" id="viewAnnouncementModal" tabindex="-1" aria-labelledby="viewAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAnnouncementModalLabel">
                    <i class="fas fa-eye me-2"></i> Detail Pengumuman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <!-- Loading State -->
                <div id="viewAnnouncementLoading" class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <p class="mt-2">Memuat data...</p>
                </div>

                <!-- Content Container -->
                <div id="viewAnnouncementContent" style="display: none;">
                    <!-- Header Info -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4 id="viewTitle" class="mb-2">Judul Pengumuman</h4>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span id="viewStatusBadge" class="badge">Status</span>
                                <span id="viewPriorityBadge" class="badge">Prioritas</span>
                                <span id="viewTypeBadge" class="badge bg-info">Jenis</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-file-text me-2"></i>Isi Pengumuman</h6>
                        </div>
                        <div class="card-body">
                            <div id="viewContent" class="mb-0">
                                Konten pengumuman akan tampil di sini...
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Target Audiens</h6>
                                </div>
                                <div class="card-body">
                                    <span id="viewTargetAudience" class="badge bg-secondary">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Fitur Tambahan</h6>
                                </div>
                                <div class="card-body">
                                    <div id="viewAdditionalFeatures">
                                        <span class="text-muted">Tidak ada fitur tambahan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scheduled Info -->
                    <div id="viewScheduledInfo" class="card mt-3" style="display: none;">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Jadwal Terbit</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">
                                <i class="fas fa-calendar me-2"></i><span id="viewScheduledDate">-</span>
                                <i class="fas fa-clock ms-3 me-2"></i><span id="viewScheduledTime">-</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Error State -->
                <div id="viewAnnouncementError" class="text-center py-4" style="display: none;">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    <p class="mt-2">Gagal memuat data pengumuman</p>
                    <button class="btn btn-primary" onclick="retryLoadAnnouncement()">Coba Lagi</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="editFromView()">
                    <i class="fas fa-edit me-2"></i>Edit
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let currentEditId = null;
    let editAutoSaveInterval;

    // Fungsi: Simpan pengumuman (CREATE)
    function saveAnnouncement() {
        const form = document.getElementById('announcementForm');
        const formData = new FormData(form);

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const method = document.getElementById('_method').value;
        const url = form.action;

        fetch(url, {
            method: method === 'PUT' ? 'POST' : 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        })
        .then(res => {
            if (!res.ok) throw new Error("Gagal menyimpan data");
            return res.json();
        })
        .then(data => {
            alert(method === 'PUT' ? 'Pengumuman berhasil diupdate!' : 'Pengumuman berhasil dibuat!');
            bootstrap.Modal.getInstance(document.getElementById('announcementModal')).hide();
            location.reload();
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menyimpan data.');
        });
    }

        // Fungsi: Update preview saat edit
        function updateEditPreview() {
            const title = document.getElementById('editTitle').value;
            const content = document.getElementById('editContent').value;
            const type = document.getElementById('editType').value;
            const priority = document.getElementById('editPriority').value;
            const status = document.getElementById('editStatus').value;
            const hasPaymentButton = document.getElementById('editHasPaymentButton').checked;
            const meetLink = document.getElementById('editMeetLink').value;
            
            if (!title && !content) {
                document.getElementById('editPreviewContent').innerHTML = '<div class="text-muted">Preview akan muncul saat Anda mengetik...</div>';
                return;
            }
            
            const priorityClass = priority === 'high' ? 'bg-danger' : (priority === 'medium' ? 'bg-warning' : 'bg-success');
            const statusClass = status === 'published' ? 'bg-success' : (status === 'scheduled' ? 'bg-info' : 'bg-warning text-dark');
            
            let additionalFeatures = '';
            if (hasPaymentButton && type === 'auto welcome') {
                additionalFeatures += '<span class="badge bg-primary mt-1 me-1"><i class="fas fa-credit-card me-1"></i> Ada Button Bayar</span>';
            }
            if (meetLink && type === 'auto booking success') {
                additionalFeatures += '<span class="badge bg-success mt-1"><i class="fas fa-video me-1"></i> Ada Link Meet</span>';
            }
            
            let html = `
                <div class="border rounded p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="mb-0">${title || 'Judul Pengumuman'}</h6>
                        <div>
                            <span class="badge ${priorityClass} me-1">${priority}</span>
                            <span class="badge ${statusClass}">${status}</span>
                        </div>
                    </div>
                    <p class="mb-2">${content || 'Isi pengumuman akan muncul di sini...'}</p>
                    <div>
                        <span class="badge bg-info text-white">${type}</span>
                        ${additionalFeatures}
                    </div>
                </div>
            `;
            
            document.getElementById('editPreviewContent').innerHTML = html;
        }

        // Event listeners untuk edit modal
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk modal show
            const editModal = document.getElementById('editAnnouncementModal');
            if (editModal) {
                editModal.addEventListener('shown.bs.modal', function () {
                    // Start auto save interval
                    editAutoSaveInterval = setInterval(() => {
                        const title = document.getElementById('editTitle').value;
                        const content = document.getElementById('editContent').value;

                        if (title || content) {
                            console.log('Auto-saving edit draft...');
                            // saveEditDraft(); // Uncomment jika diperlukan
                        }
                    }, 30000);
                    
                    // Focus on title field
                    document.getElementById('editTitle').focus();
                });

                editModal.addEventListener('hidden.bs.modal', function () {
                    // Clear auto save interval
                    if (editAutoSaveInterval) {
                        clearInterval(editAutoSaveInterval);
                    }
                    
                    // Reset form
                    document.getElementById('editAnnouncementForm').reset();
                    document.getElementById('editPreviewContent').innerHTML = '<div class="text-muted">Preview akan muncul saat Anda mengetik...</div>';
                    currentEditId = null;
                });
            }

            // Event listeners untuk realtime preview
            const editTitle = document.getElementById('editTitle');
            const editContent = document.getElementById('editContent');
            const editType = document.getElementById('editType');
            const editStatus = document.getElementById('editStatus');
            const editPriority = document.getElementById('editPriority');
            const editHasPaymentButton = document.getElementById('editHasPaymentButton');

            if (editTitle) editTitle.addEventListener('input', updateEditPreview);
            if (editContent) editContent.addEventListener('input', updateEditPreview);
            if (editType) editType.addEventListener('change', toggleEditAutoFields);
            if (editStatus) editStatus.addEventListener('change', toggleEditAutoFields);
            if (editPriority) editPriority.addEventListener('change', updateEditPreview);
            if (editHasPaymentButton) editHasPaymentButton.addEventListener('change', updateEditPreview);
        });
    
    // Fungsi: Filter (Simulasi)
    function filterAnnouncements() {
        const status = document.getElementById('filterStatus').value;
        const type = document.getElementById('filterType').value;
        const search = document.getElementById('searchAnnouncement').value.toLowerCase();
        alert('Filter diterapkan! (Simulasi)');
    }

    // Auto Save Draft Tambah Pengumuman (optional)
    let autoSaveInterval;

    document.getElementById('announcementModal').addEventListener('shown.bs.modal', function () {
        toggleAutoFields(); // trigger pertama kali saat modal dibuka

        autoSaveInterval = setInterval(() => {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;

            if (title || content) {
                console.log('Auto-saving draft (create)...');
            }
        }, 30000);
    });

    document.getElementById('announcementModal').addEventListener('hidden.bs.modal', function () {
        clearInterval(autoSaveInterval);
        document.getElementById('announcementForm').reset();
        document.getElementById('_method').value = 'POST';
        toggleAutoFields(); // reset field state
    });

    // Fungsi: Toggle field tambahan saat tipe/status berubah (CREATE)
    function toggleAutoFields() {
        const type = document.getElementById('type').value;
        const status = document.getElementById('status').value;

        const paymentField = document.getElementById('paymentButtonField');
        const meetLinkField = document.getElementById('meetLinkField');
        const scheduledField = document.getElementById('scheduledDateField');
        const paymentCheckbox = document.getElementById('hasPaymentButton');

        // Sembunyikan default
        paymentField.style.display = 'none';
        meetLinkField.style.display = 'none';

        // Munculkan payment button untuk type yang butuh pembayaran
        if (['auto welcome', 'auto dp request', 'auto booking success'].includes(type)) {
            paymentField.style.display = 'block';
            paymentCheckbox.checked = true;
        }

        // Munculkan meet link hanya untuk booking success
        if (type === 'auto booking success') {
            meetLinkField.style.display = 'block';
        }

        // Munculkan jadwal jika status scheduled
        scheduledField.style.display = (status === 'scheduled') ? 'block' : 'none';
    }

    // Event listeners untuk real-time toggle (CREATE)
    document.getElementById('type').addEventListener('change', toggleAutoFields);
    document.getElementById('status').addEventListener('change', toggleAutoFields);

    // Fungsi: Edit pengumuman (Updated)
    function editAnnouncement(id) {
        currentEditId = id;
        
        // Show loading state
        const modal = new bootstrap.Modal(document.getElementById('editAnnouncementModal'));
        modal.show();
        
        // Set loading state
        document.getElementById('editPreviewContent').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat data...</div>';
        
        fetch(`/admin/pengumuman/${id}/edit`)
            .then(res => {
                if (!res.ok) throw new Error('Gagal memuat data');
                return res.json();
            })
            .then(data => {
                const form = document.getElementById('editAnnouncementForm');
                form.action = `/admin/pengumuman/${id}`;
                
                // Populate form fields
                document.getElementById('editTitle').value = data.title || '';
                document.getElementById('editPriority').value = data.priority || 'medium';
                document.getElementById('editType').value = data.type || 'manual';
                document.getElementById('editTargetAudience').value = data.target_audience || 'all students';
                document.getElementById('editStatus').value = data.status || 'draft';
                document.getElementById('editContent').value = data.content || '';
                document.getElementById('editMeetLink').value = data.meet_link || '';
                document.getElementById('editScheduledDate').value = data.scheduled_date || '';
                document.getElementById('editScheduledTime').value = data.scheduled_time || '';
                document.getElementById('editHasPaymentButton').checked = data.has_payment_button === 1;
                
                // Toggle conditional fields
                toggleEditAutoFields();
                
                // Update preview
                updateEditPreview();
            })
            .catch(error => {
                console.error(error);
                alert('Gagal memuat data pengumuman. Silakan coba lagi.');
                modal.hide();
            });
    }

    // Fungsi: Update pengumuman
    function updateAnnouncement() {
        const form = document.getElementById('editAnnouncementForm');
        const formData = new FormData(form);

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Show loading state
        const updateBtn = document.querySelector('button[onclick="updateAnnouncement()"]');
        const originalText = updateBtn.innerHTML;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        updateBtn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => {
            if (!res.ok) throw new Error("Gagal memperbarui pengumuman");
            return res.json();
        })
        .then(data => {
            // Show success message
            showNotification('Pengumuman berhasil diperbarui!', 'success');
            
            // Hide modal
            bootstrap.Modal.getInstance(document.getElementById('editAnnouncementModal')).hide();
            
            // Reload page or update table row
            setTimeout(() => {
                location.reload();
            }, 1000);
        })
        .catch(err => {
            console.error(err);
            showNotification('Terjadi kesalahan saat memperbarui pengumuman.', 'error');
        })
        .finally(() => {
            // Reset button state
            updateBtn.innerHTML = originalText;
            updateBtn.disabled = false;
        });
    }

    // Fungsi: Simpan draft edit
    function saveEditDraft() {
        const form = document.getElementById('editAnnouncementForm');
        const formData = new FormData(form);
        
        // Set status to draft
        formData.set('status', 'draft');
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => {
            if (!res.ok) throw new Error("Gagal menyimpan draft");
            return res.json();
        })
        .then(data => {
            showNotification('Draft berhasil disimpan!', 'success');
            document.getElementById('editAutoSaveStatus').innerHTML = '<i class="fas fa-check text-success me-1"></i>Draft tersimpan pada ' + new Date().toLocaleTimeString();
        })
        .catch(err => {
            console.error(err);
            showNotification('Gagal menyimpan draft.', 'error');
        });
    }

    // Fungsi: Toggle field tambahan untuk edit
    function toggleEditAutoFields() {
        const type = document.getElementById('editType').value;
        const status = document.getElementById('editStatus').value;

        const paymentField = document.getElementById('editPaymentButtonField');
        const meetLinkField = document.getElementById('editMeetLinkField');
        const scheduledField = document.getElementById('editScheduledDateField');

        // Sembunyikan default
        paymentField.style.display = 'none';
        meetLinkField.style.display = 'none';

        // Munculkan payment button untuk type yang butuh pembayaran
        if (['auto welcome', 'auto dp request', 'auto booking success'].includes(type)) {
            paymentField.style.display = 'block';
        }

        // Munculkan meet link hanya untuk booking success
        if (type === 'auto booking success') {
            meetLinkField.style.display = 'block';
        }

        // Munculkan jadwal jika status scheduled
        scheduledField.style.display = (status === 'scheduled') ? 'block' : 'none';

        updateEditPreview();
    }


    // Fungsi: Show notification
    function showNotification(message, type = 'info') {
        const alertClass = type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-info');
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Event listeners untuk edit modal
    document.getElementById('editAnnouncementModal').addEventListener('shown.bs.modal', function () {
        // Start auto save interval
        editAutoSaveInterval = setInterval(() => {
            const title = document.getElementById('editTitle').value;
            const content = document.getElementById('editContent').value;

            if (title || content) {
                console.log('Auto-saving edit draft...');
                saveEditDraft();
            }
        }, 30000); // Auto save every 30 seconds
        
        // Focus on title field
        document.getElementById('editTitle').focus();
    });

    document.getElementById('editAnnouncementModal').addEventListener('hidden.bs.modal', function () {
        // Clear auto save interval
        if (editAutoSaveInterval) {
            clearInterval(editAutoSaveInterval);
        }
        
        // Reset form
        document.getElementById('editAnnouncementForm').reset();
        document.getElementById('editPreviewContent').innerHTML = '<div class="text-muted">Preview akan muncul saat Anda mengetik...</div>';
        document.getElementById('editAutoSaveStatus').innerHTML = '<i class="fas fa-save me-1"></i>Draft disimpan otomatis setiap 30 detik';
        currentEditId = null;
    });

    // Event listeners untuk realtime preview
    document.getElementById('editTitle').addEventListener('input', updateEditPreview);
    document.getElementById('editContent').addEventListener('input', updateEditPreview);
    document.getElementById('editType').addEventListener('change', toggleEditAutoFields);
    document.getElementById('editStatus').addEventListener('change', toggleEditAutoFields);
    document.getElementById('editPriority').addEventListener('change', updateEditPreview);

    // Keyboard shortcuts
    document.getElementById('editAnnouncementModal').addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save draft
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            saveEditDraft();
        }
        
        // Ctrl/Cmd + Enter to update
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            updateAnnouncement();
        }
    });

    // Fungsi: View announcement
    if (typeof window.currentViewId === 'undefined') {
        window.currentViewId = null;
    }

    // Function utama untuk view announcement
    function viewAnnouncement(id) {
        console.log('👁️ View announcement ID:', id);
        window.currentViewId = id;
        
        // Cek apakah modal ada
        const modalElement = document.getElementById('viewAnnouncementModal');
        if (!modalElement) {
            console.error('❌ Modal viewAnnouncementModal tidak ditemukan!');
            alert('Modal detail tidak ditemukan. Pastikan modal sudah ditambahkan ke halaman.');
            return;
        }
        
        // Show modal dengan loading state
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        
        // Reset states
        showLoadingStateView();
        
        // Fetch data dari server
        fetch(`/admin/pengumuman/${id}/show`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                            document.querySelector('input[name="_token"]')?.value || ''
            }
        })
        .then(response => {
            console.log('📡 Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('📋 Data received:', data);
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            // Populate modal dengan data
            populateViewModal(data);
            showContentStateView();
        })
        .catch(error => {
            console.error('❌ Error loading announcement:', error);
            showErrorStateView();
            
            // Show user-friendly error
            alert('Gagal memuat detail pengumuman: ' + error.message);
        });
    }

    // Function untuk populate data ke modal
    function populateViewModal(data) {
        // Basic Info
        const titleEl = document.getElementById('viewTitle');
        const contentEl = document.getElementById('viewContent');
        const targetEl = document.getElementById('viewTargetAudience');
        const dateEl = document.getElementById('viewCreatedDate');
        
        if (titleEl) titleEl.textContent = data.title || 'Tidak ada judul';
        if (contentEl) contentEl.innerHTML = formatContentView(data.content || 'Tidak ada konten');
        if (targetEl) targetEl.textContent = formatTargetAudienceView(data.target_audience);
        if (dateEl) dateEl.textContent = formatDateView(data.created_at);
        
        // Status Badges
        updateStatusBadgeView(data.status);
        updatePriorityBadgeView(data.priority);
        updateTypeBadgeView(data.type);
        
        // Additional Features
        updateAdditionalFeaturesView(data);
        
        // Scheduled Info
        updateScheduledInfoView(data);
    }

    // Helper Functions untuk View
    function showLoadingStateView() {
        const loadingEl = document.getElementById('viewAnnouncementLoading');
        const contentEl = document.getElementById('viewAnnouncementContent');
        const errorEl = document.getElementById('viewAnnouncementError');
        
        if (loadingEl) loadingEl.style.display = 'block';
        if (contentEl) contentEl.style.display = 'none';
        if (errorEl) errorEl.style.display = 'none';
    }

    function showContentStateView() {
        const loadingEl = document.getElementById('viewAnnouncementLoading');
        const contentEl = document.getElementById('viewAnnouncementContent');
        const errorEl = document.getElementById('viewAnnouncementError');
        
        if (loadingEl) loadingEl.style.display = 'none';
        if (contentEl) contentEl.style.display = 'block';
        if (errorEl) errorEl.style.display = 'none';
    }

    function showErrorStateView() {
        const loadingEl = document.getElementById('viewAnnouncementLoading');
        const contentEl = document.getElementById('viewAnnouncementContent');
        const errorEl = document.getElementById('viewAnnouncementError');
        
        if (loadingEl) loadingEl.style.display = 'none';
        if (contentEl) contentEl.style.display = 'none';
        if (errorEl) errorEl.style.display = 'block';
    }

    function updateStatusBadgeView(status) {
        const badge = document.getElementById('viewStatusBadge');
        if (!badge) return;
        
        const statusMap = {
            'published': { class: 'bg-success', text: 'Terbit' },
            'draft': { class: 'bg-warning text-dark', text: 'Draft' },
            'scheduled': { class: 'bg-info', text: 'Terjadwal' }
        };
        
        const statusInfo = statusMap[status] || { class: 'bg-secondary', text: status };
        badge.className = `badge ${statusInfo.class}`;
        badge.textContent = statusInfo.text;
    }

    function updatePriorityBadgeView(priority) {
        const badge = document.getElementById('viewPriorityBadge');
        if (!badge) return;
        
        const priorityMap = {
            'high': { class: 'bg-danger', text: 'Tinggi' },
            'medium': { class: 'bg-warning', text: 'Sedang' },
            'low': { class: 'bg-success', text: 'Rendah' }
        };
        
        const priorityInfo = priorityMap[priority] || { class: 'bg-secondary', text: priority };
        badge.className = `badge ${priorityInfo.class}`;
        badge.textContent = `Prioritas ${priorityInfo.text}`;
    }

    function updateTypeBadgeView(type) {
        const badge = document.getElementById('viewTypeBadge');
        if (!badge) return;
        
        const typeMap = {
            'manual': 'Manual',
            'auto welcome': 'Otomatis - Welcome',
            'auto booking success': 'Otomatis - Booking Berhasil'
        };
        
        badge.textContent = typeMap[type] || type;
    }

    function updateAdditionalFeaturesView(data) {
        const container = document.getElementById('viewAdditionalFeatures');
        if (!container) return;
        
        let features = [];
        
        // Payment Button
        if (data.has_payment_button === 1 || data.has_payment_button === true) {
            features.push('<span class="badge bg-primary me-2 mb-1"><i class="fas fa-credit-card me-1"></i> Ada Button Bayar</span>');
        }
        
        // Meet Link
        if (data.meet_link) {
            features.push(`<span class="badge bg-success me-2 mb-1"><i class="fas fa-video me-1"></i> Ada Link Meet</span>`);
            features.push(`<br><small class="text-muted">Link: <a href="${data.meet_link}" target="_blank" class="text-decoration-none">${data.meet_link}</a></small>`);
        }
        
        container.innerHTML = features.length > 0 ? features.join('') : '<span class="text-muted">Tidak ada fitur tambahan</span>';
    }

    function updateScheduledInfoView(data) {
        const container = document.getElementById('viewScheduledInfo');
        if (!container) return;
        
        if (data.status === 'scheduled' && (data.scheduled_date || data.scheduled_time)) {
            container.style.display = 'block';
            const dateEl = document.getElementById('viewScheduledDate');
            const timeEl = document.getElementById('viewScheduledTime');
            
            if (dateEl) dateEl.textContent = data.scheduled_date ? formatDateView(data.scheduled_date) : '-';
            if (timeEl) timeEl.textContent = data.scheduled_time || '-';
        } else {
            container.style.display = 'none';
        }
    }

    function formatContentView(content) {
        // Convert line breaks to HTML
        return content.replace(/\n/g, '<br>');
    }

    function formatTargetAudienceView(audience) {
        const audienceMap = {
            'all students': 'Semua Siswa',
            'new registrants': 'Pendaftar Baru',
            'paid students': 'Siswa yang Sudah Bayar',
            'active students': 'Siswa Aktif',
            'prospective students': 'Calon Siswa'
        };
        
        return audienceMap[audience] || audience;
    }

    function formatDateView(dateString) {
        if (!dateString) return '-';
        
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        } catch (e) {
            return dateString;
        }
    }

    function retryLoadAnnouncement() {
        if (window.currentViewId) {
            viewAnnouncement(window.currentViewId);
        }
    }

    function editFromView() {
        if (window.currentViewId) {
            // Close view modal
            const viewModalEl = document.getElementById('viewAnnouncementModal');
            if (viewModalEl) {
                const viewModal = bootstrap.Modal.getInstance(viewModalEl);
                if (viewModal) viewModal.hide();
            }
            
            // Open edit modal (pastikan function editAnnouncement ada)
            setTimeout(() => {
                if (typeof editAnnouncement === 'function') {
                    editAnnouncement(window.currentViewId);
                } else {
                    console.error('Function editAnnouncement not found');
                    alert('Fitur edit tidak tersedia');
                }
            }, 300);
        }
    }

    // Event Listeners - Pastikan DOM sudah ready
    document.addEventListener('DOMContentLoaded', function() {
        const viewModal = document.getElementById('viewAnnouncementModal');
        if (viewModal) {
            viewModal.addEventListener('hidden.bs.modal', function () {
                window.currentViewId = null;
                showLoadingStateView();
            });
            console.log('✅ View modal event listener terpasang');
        } else {
            console.warn('⚠️ Modal viewAnnouncementModal belum ada saat DOM ready');
        }
    });

    console.log('✅ View Announcement functions loaded');

    // Fungsi konfirmasi hapus dengan SweetAlert2
        function confirmDelete(id, title) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus pengumuman:<br><strong>"${title}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
                customClass: {
                    confirmButton: 'btn btn-danger me-4',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {// Set action URL dan submit form
                            const form = document.getElementById('deleteForm');
                            form.action = `{{ route('admin.pengumuman.destroy', '') }}/${id}`;
                            form.submit();
                            resolve();
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Form sudah disubmit di preConfirm
                        // Show loading toast
                        Swal.fire({
                            title: 'Menghapus...',
                            text: 'Sedang memproses penghapusan',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    }
                }).catch((error) => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus pengumuman',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                });
        }

        // Toast notification untuk success delete (jika menggunakan AJAX)
        function showDeleteSuccessToast(title) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'Berhasil dihapus!',
                text: `Pengumuman "${title}" berhasil dihapus`
            });
        }

        // Show success alert jika ada session delete_success
        @if(session('delete_success'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('delete_success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false,
                    timer: 5000,
                    timerProgressBar: true
                });
            });
        @endif

</script>
@section('scripts')
@endsection