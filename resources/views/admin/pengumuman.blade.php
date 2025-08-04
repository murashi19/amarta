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
                                        <h3 class="mb-0">5</h3>
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
                                        <h3 class="mb-0">3</h3>
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
                                        <h3 class="mb-0">2</h3>
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
                                        <h3 class="mb-0">152</h3>
                                        <p class="mb-0">Total Dilihat</p>
                                    </div>
                                    <div>
                                        <i class="fas fa-eye fa-2x opacity-75"></i>
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
                                        <option value="auto_welcome">Otomatis - Welcome</option>
                                        <option value="auto_booking_success">Otomatis - Booking Berhasil</option>
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
                                <div class="alert alert-success">{{ session('success') }}</div>
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
                                        <th width="8%">Views</th>
                                        <th width="10%">Tanggal</th>
                                        <th width="4%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($announcements as $index => $announcement)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $announcement->title }}</strong><br>
                                                    <small class="text-muted">{{ $announcement->content }}</small>
                                                    @if($announcement->has_payment_button)
                                                        <br>
                                                        <span class="badge bg-primary mt-1"><i class="fas fa-credit-card me-1"></i> Ada Button Bayar</span>
                                                    @elseif($announcement->meet_link)
                                                        <br>
                                                        <span class="badge bg-success mt-1"><i class="fas fa-video me-1"></i> Ada Link Meet</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td><span class="badge bg-info text-white">{{ $announcement->type }}</span></td>
                                            <td><span class="badge {{ $announcement->status === 'published' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($announcement->status) }}</span></td>
                                            <td><span class="badge {{ $announcement->priority === 'high' ? 'bg-danger' : ($announcement->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">Prioritas {{ ucfirst($announcement->priority) }}</span></td>
                                            <td><i class="fas fa-users me-1"></i> {{ $announcement->target_audience }}</td>
                                            <td><span class="badge bg-info">{{ $announcement->views_count }} views</span></td>
                                            <td><small>{{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}</small></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" onclick="editAnnouncement({{ $announcement->id }})">
                                                                <i class="fas fa-edit me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="viewAnnouncement({{ $announcement->id }})">
                                                                <i class="fas fa-eye me-2"></i> Lihat
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.pengumuman.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

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
                                            <option value="auto_welcome">Otomatis - Welcome</option>
                                            <option value="auto_booking_success">Otomatis - Booking Berhasil</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="target_audience" class="form-label">Target Audiens</label>
                                        <select class="form-select" id="target_audience" name="target_audience">
                                            <option value="all_students">Semua Siswa</option>
                                            <option value="new_registrants">Pendaftar Baru</option>
                                            <option value="paid_students">Siswa yang Sudah Bayar</option>
                                            <option value="active_students">Siswa Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
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
                                        <input class="form-check-input" type="checkbox" id="has_payment_button" name="has_payment_button" value="1" checked>
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
                                <div class="modal-footer">
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
                                            <option value="auto_welcome">Otomatis - Welcome</option>
                                            <option value="auto_booking_success">Otomatis - Booking Berhasil</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="editTargetAudience" class="form-label">Target Audiens</label>
                                        <select class="form-select" id="editTargetAudience" name="target_audience">
                                            <option value="all_students">Semua Siswa</option>
                                            <option value="new_registrants">Pendaftar Baru</option>
                                            <option value="paid_students">Siswa yang Sudah Bayar</option>
                                            <option value="active_students">Siswa Aktif</option>
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

                                <!-- Preview Section -->
                                <div class="mt-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="fas fa-eye me-2"></i>Preview</h6>
                                        </div>
                                        <div class="card-body" id="editPreviewContent">
                                            <div class="text-muted">Preview akan muncul saat Anda mengetik...</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Auto Save Indicator -->
                                <div class="mt-2">
                                    <small class="text-muted" id="editAutoSaveStatus">
                                        <i class="fas fa-save me-1"></i>Draft disimpan otomatis setiap 30 detik
                                    </small>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                            <button type="button" class="btn btn-outline-primary" onclick="saveEditDraft()">
                                <i class="fas fa-save me-2"></i>Simpan Draft
                            </button>
                            <button type="button" class="btn btn-primary" onclick="updateAnnouncement()">
                                <i class="fas fa-check me-2"></i>Update Pengumuman
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal View Pengumuman -->
            <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewModalLabel">
                                <i class="fas fa-eye me-2"></i> Preview Pengumuman
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="viewModalContent">
                        </div>
                    </div>
                </div>
            </div>
@endsection


<script>
    let currentEditId = null;
    let editAutoSaveInterval;

    // Fungsi: Simpan (Create/Update)
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

    // Fungsi: Edit pengumuman (FIXED)
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
                    console.log('Data loaded:', data); // Debug log
                    
                    const form = document.getElementById('editAnnouncementForm');
                    form.action = `/admin/pengumuman/${id}`;
                    
                    // Populate form fields
                    document.getElementById('editTitle').value = data.title || '';
                    document.getElementById('editPriority').value = data.priority || 'medium';
                    document.getElementById('editType').value = data.type || 'manual';
                    document.getElementById('editTargetAudience').value = data.target_audience || 'all_students';
                    document.getElementById('editStatus').value = data.status || 'draft';
                    document.getElementById('editContent').value = data.content || '';
                    document.getElementById('editMeetLink').value = data.meet_link || '';
                    document.getElementById('editScheduledDate').value = data.scheduled_date || '';
                    document.getElementById('editScheduledTime').value = data.scheduled_time || '';
                    
                    // PERBAIKAN: Handle checkbox dengan benar
                    const paymentCheckbox = document.getElementById('editHasPaymentButton');
                    if (paymentCheckbox) {
                        // Convert to boolean and set checkbox
                        paymentCheckbox.checked = Boolean(data.has_payment_button === 1 || data.has_payment_button === true || data.has_payment_button === "1");
                        console.log('Payment button value:', data.has_payment_button, 'Checkbox checked:', paymentCheckbox.checked); // Debug
                    }
                    
                    // Toggle conditional fields SETELAH semua data dimuat
                    toggleEditAutoFields();
                    
                    // Update preview
                    updateEditPreview();
                })
                .catch(error => {
                    console.error('Edit error:', error);
                    alert('Gagal memuat data pengumuman. Silakan coba lagi.');
                    modal.hide();
                });
        }

        // Fungsi: Update pengumuman (FIXED)
        function updateAnnouncement() {
            const form = document.getElementById('editAnnouncementForm');
            
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // PERBAIKAN: Manual handling untuk checkbox
            const formData = new FormData();
            // Ambil semua field input biasa
            const regularFields = [
                'title', 'content', 'type', 'status', 'priority', 
                'target_audience', 'meet_link', 'scheduled_date', 'scheduled_time'
            ];
            
            regularFields.forEach(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    formData.append(fieldName, field.value || '');
                }
            });
            
           // KHUSUS HANDLING CHECKBOX: Selalu kirim nilai (1 atau 0)
            const paymentCheckbox = document.getElementById('editHasPaymentButton');
            if (paymentCheckbox) {
                const checkboxValue = paymentCheckbox.checked ? '1' : '0';
                formData.append('has_payment_button', checkboxValue);
                console.log('🔥 Checkbox Value Being Sent:', checkboxValue, 'Checked:', paymentCheckbox.checked);
            } else {
                // Fallback jika checkbox tidak ditemukan
                formData.append('has_payment_button', '0');
                console.log('⚠️ Checkbox not found, sending 0');
            }
            
            // Tambahkan CSRF token dan method
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('_method', 'PUT');

            // Show loading state
            const updateBtn = document.querySelector('button[onclick="updateAnnouncement()"]');
            const originalText = updateBtn.innerHTML;
            updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            updateBtn.disabled = true;

            fetch(form.action, {
                method: 'POST', // Laravel menggunakan POST dengan _method=PUT
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Update response:', data); // Debug
                
                if (data.success) {
                    showNotification('Pengumuman berhasil diperbarui!', 'success');
                    
                    // Hide modal
                    bootstrap.Modal.getInstance(document.getElementById('editAnnouncementModal')).hide();
                    
                    // Reload page
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Update gagal');
                }
            })
            .catch(err => {
                console.error('Update error:', err);
                showNotification('Terjadi kesalahan saat memperbarui pengumuman: ' + err.message, 'error');
            })
            .finally(() => {
                // Reset button state
                updateBtn.innerHTML = originalText;
                updateBtn.disabled = false;
            });
        }

        // Fungsi: Toggle field tambahan untuk edit (FIXED)
        function toggleEditAutoFields() {
            const type = document.getElementById('editType').value;
            const status = document.getElementById('editStatus').value;
            
            console.log('Toggle fields - Type:', type, 'Status:', status); // Debug
            
            // Show/hide payment button field
            const paymentField = document.getElementById('editPaymentButtonField');
            if (paymentField) {
                paymentField.style.display = type === 'auto_welcome' ? 'block' : 'none';
                console.log('Payment field display:', paymentField.style.display); // Debug
            }
            
            // Show/hide meet link field
            const meetField = document.getElementById('editMeetLinkField');
            if (meetField) {
                meetField.style.display = type === 'auto_booking_success' ? 'block' : 'none';
            }
            
            // Show/hide scheduled date field
            const scheduledField = document.getElementById('editScheduledDateField');
            if (scheduledField) {
                scheduledField.style.display = status === 'scheduled' ? 'block' : 'none';
            }
            
            // Update preview
            updateEditPreview();
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
            if (hasPaymentButton && type === 'auto_welcome') {
                additionalFeatures += '<span class="badge bg-primary mt-1 me-1"><i class="fas fa-credit-card me-1"></i> Ada Button Bayar</span>';
            }
            if (meetLink && type === 'auto_booking_success') {
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

    
    // Fungsi: Filter (Simulasi)
    function filterAnnouncements() {
        const status = document.getElementById('filterStatus').value;
        const type = document.getElementById('filterType').value;
        const search = document.getElementById('searchAnnouncement').value.toLowerCase();
        alert('Filter diterapkan! (Simulasi)');
    }

    // Auto Save Draft
    let autoSaveInterval;

    document.getElementById('announcementModal').addEventListener('shown.bs.modal', function () {
        autoSaveInterval = setInterval(() => {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;

            if (title || content) {
                console.log('Auto-saving draft...');
            }
        }, 30000);
    });

    document.getElementById('announcementModal').addEventListener('hidden.bs.modal', function () {
        clearInterval(autoSaveInterval);
        document.getElementById('announcementForm').reset();
        document.getElementById('_method').value = 'POST';
        currentEditId = null;
    });

    // Realtime preview
    function previewAnnouncement() {
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;
        const type = document.getElementById('type').value;
        // Bisa ditambahkan preview realtime di bawah
    }

    document.getElementById('title').addEventListener('input', previewAnnouncement);
    document.getElementById('content').addEventListener('input', previewAnnouncement);

    // Fungsi: Toggle field tambahan
    function toggleAutoFields() {
        const type = document.getElementById('type').value;
        document.getElementById('paymentButtonField').style.display = type === 'auto_welcome' ? 'block' : 'none';
        document.getElementById('meetLinkField').style.display = type === 'auto_booking_success' ? 'block' : 'none';
        document.getElementById('scheduledDateField').style.display = document.getElementById('status').value === 'scheduled' ? 'block' : 'none';
    }

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
                    document.getElementById('editTargetAudience').value = data.target_audience || 'all_students';
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
            
            // Show/hide payment button field
            document.getElementById('editPaymentButtonField').style.display = 
                type === 'auto_welcome' ? 'block' : 'none';
            
            // Show/hide meet link field
            document.getElementById('editMeetLinkField').style.display = 
                type === 'auto_booking_success' ? 'block' : 'none';
            
            // Show/hide scheduled date field
            document.getElementById('editScheduledDateField').style.display = 
                status === 'scheduled' ? 'block' : 'none';
                
            // Update preview
            updateEditPreview();
        }

        // Fungsi: Update preview saat edit
        function updateEditPreview() {
            const title = document.getElementById('editTitle').value;
            const content = document.getElementById('editContent').value;
            const type = document.getElementById('editType').value;
            const priority = document.getElementById('editPriority').value;
            const status = document.getElementById('editStatus').value;
            
            if (!title && !content) {
                document.getElementById('editPreviewContent').innerHTML = '<div class="text-muted">Preview akan muncul saat Anda mengetik...</div>';
                return;
            }
            
            const priorityClass = priority === 'high' ? 'bg-danger' : (priority === 'medium' ? 'bg-warning' : 'bg-success');
            const statusClass = status === 'published' ? 'bg-success' : (status === 'scheduled' ? 'bg-info' : 'bg-warning text-dark');
            
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
                    <small class="text-muted">
                        <span class="badge bg-info text-white">${type}</span>
                    </small>
                </div>
            `;
            
            document.getElementById('editPreviewContent').innerHTML = html;
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

</script>
@section('scripts')
@endsection