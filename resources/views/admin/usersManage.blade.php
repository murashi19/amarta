@extends('layouts.dashboardAdmin')

@section('title', 'Manajemen Pengguna')

@push('styles')
<style>
    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .badge-success { background-color: #dcfce7; color: #166534; }
    .badge-warning { background-color: #fef3c7; color: #92400e; }
    .badge-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-info { background-color: #dbeafe; color: #1e40af; }
    
    .table-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }
    
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    
    .modal-content {
        background: white;
        border-radius: 0.5rem;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .filter-section {
        background: #f8fafc;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .user-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        text-align: center;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #1f2937;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Manajemen Pengguna</h1>
            <p class="text-muted">Kelola data pengguna sistem LPK</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="exportUsers()">
                <i class="fas fa-download"></i> Export
            </button>
            <button class="btn btn-primary" onclick="openCreateModal()">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </button>
        </div>
    </div>

    <!-- Statistics -->
    <div class="user-stats">
        <div class="stat-card">
            <div class="stat-number" id="totalUsers">{{ $users->total() }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="activeUsers">
                {{ $users->where('status.name', 'Active')->count() }}
            </div>
            <div class="stat-label">Pengguna Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="completedPayment">
                {{ $users->filter(function($user) { return $user->hasCompletedBookingPayment(); })->count() }}
            </div>
            <div class="stat-label">Sudah Bayar</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="hasGoogleMeeting">
                {{ $users->filter(function($user) { return $user->getActiveGoogleMeeting(); })->count() }}
            </div>
            <div class="stat-label">Ada Meeting</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Pencarian</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" 
                               placeholder="Nama, email, telepon...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="applyFilters()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="statusFilter" onchange="applyFilters()">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" id="roleFilter" onchange="applyFilters()">
                        <option value="">Semua Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Level Bahasa Jepang</label>
                    <select class="form-control" id="japaneseLevelFilter" onchange="applyFilters()">
                        <option value="">Semua Level</option>
                        <option value="N5">N5 (Pemula)</option>
                        <option value="N4">N4 (Menengah Bawah)</option>
                        <option value="N3">N3 (Menengah)</option>
                        <option value="N2">N2 (Menengah Atas)</option>
                        <option value="N1">N1 (Mahir)</option>
                        <option value="none">Belum Menguasai</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-secondary flex-fill" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button class="btn btn-danger" id="bulkDeleteBtn" 
                                onclick="bulkDelete()" style="display: none;">
                            <i class="fas fa-trash"></i> Hapus Terpilih
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
                            <th>Pengguna</th>
                            <th>Kontak</th>
                            <th>Level Jepang</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Payment</th>
                            <th>Meeting</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <input type="checkbox" class="user-checkbox" value="{{ $user->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    @if($user->phone_number)
                                        <div><i class="fas fa-phone text-muted me-1"></i> {{ $user->phone_number }}</div>
                                    @endif
                                    @if($user->birth_date)
                                        <small class="text-muted">
                                            <i class="fas fa-calendar text-muted me-1"></i> 
                                            {{ $user->birth_date->format('d/m/Y') }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($user->japanese_level)
                                    <span class="badge badge-info">{{ $user->getJapaneseLevelText() }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status)
                                    <span class="badge badge-{{ $user->status->name == 'Active' ? 'success' : 'warning' }}">
                                        {{ $user->status->name }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-info me-1">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->hasCompletedBookingPayment())
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Lunas
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->getActiveGoogleMeeting())
                                    <span class="badge badge-success">
                                        <i class="fas fa-video"></i> Ada
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <button class="btn btn-sm btn-outline-info" 
                                            onclick="viewUser({{ $user->id }})" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" 
                                            onclick="editUser({{ $user->id }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteUser({{ $user->id }})" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} 
                dari {{ $users->total() }} data
            </div>
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- User Modal -->
<div id="userModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header p-4 border-bottom">
            <h5 class="modal-title" id="modalTitle">Tambah Pengguna</h5>
            <button class="btn-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body p-4">
            <form id="userForm">
                @csrf
                <input type="hidden" id="userId" name="user_id">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="userName" name="name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="userEmail" name="email" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Password <span class="text-danger" id="passwordRequired">*</span></label>
                            <input type="password" class="form-control" id="userPassword" name="password">
                            <div class="invalid-feedback"></div>
                            <small class="text-muted" id="passwordHelp">Minimal 8 karakter</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Konfirmasi Password <span class="text-danger" id="confirmPasswordRequired">*</span></label>
                            <input type="password" class="form-control" id="userPasswordConfirmation" name="password_confirmation">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nomor Telepon</label>
                            <input type="text" class="form-control" id="userPhone" name="phone_number">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" class="form-control" id="userBirthDate" name="birth_date">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <textarea class="form-control" id="userAddress" name="address" rows="2"></textarea>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Pendidikan</label>
                            <input type="text" class="form-control" id="userEducation" name="education">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Level Bahasa Jepang</label>
                            <select class="form-control" id="userJapaneseLevel" name="japanese_level">
                                <option value="">Pilih Level</option>
                                <option value="N5">N5 (Pemula)</option>
                                <option value="N4">N4 (Menengah Bawah)</option>
                                <option value="N3">N3 (Menengah)</option>
                                <option value="N2">N2 (Menengah Atas)</option>
                                <option value="N1">N1 (Mahir)</option>
                                <option value="none">Belum Menguasai</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Motivasi</label>
                    <textarea class="form-control" id="userMotivation" name="motivation" rows="3"></textarea>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="userStatus" name="status_id" required>
                                <option value="">Pilih Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Role <span class="text-danger">*</span></label>
                            <div id="userRoles">
                                @foreach($roles as $role)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="roles[]" value="{{ $role->id }}" 
                                               id="role{{ $role->id }}">
                                        <label class="form-check-label" for="role{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer p-4 border-top">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
            <button type="button" class="btn btn-primary" onclick="saveUser()" id="saveBtn">
                <span class="spinner-border spinner-border-sm me-2" style="display: none;"></span>
                Simpan
            </button>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header p-4 border-bottom">
            <h5 class="modal-title">Detail Pengguna</h5>
            <button class="btn-close" onclick="closeDetailModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body p-4" id="userDetailContent">
            <!-- Detail content will be loaded here -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentPage = 1;
let totalPages = {{ $users->lastPage() }};

// Modal Functions
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Pengguna';
    document.getElementById('userId').value = '';
    document.getElementById('userForm').reset();
    document.getElementById('passwordRequired').style.display = 'inline';
    document.getElementById('confirmPasswordRequired').style.display = 'inline';
    document.getElementById('passwordHelp').textContent = 'Minimal 8 karakter';
    clearFormErrors();
    document.getElementById('userModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('userModal').style.display = 'none';
    clearFormErrors();
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

// CRUD Functions
function saveUser() {
    const form = document.getElementById('userForm');
    const formData = new FormData(form);
    const userId = document.getElementById('userId').value;
    const isEdit = userId !== '';
    
    const url = isEdit ? `/admin/users/${userId}` : '/admin/users';
    const method = isEdit ? 'PUT' : 'POST';
    
    if (isEdit) {
        formData.append('_method', 'PUT');
    }
    
    showLoading(true);
    clearFormErrors();
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        
        if (data.success) {
            showAlert('success', data.message);
            closeModal();
            location.reload(); // Reload to update table
        } else {
            if (data.errors) {
                showFormErrors(data.errors);
            } else {
                showAlert('error', data.message || 'Terjadi kesalahan');
            }
        }
    })
    .catch(error => {
        showLoading(false);
        showAlert('error', 'Terjadi kesalahan jaringan');
        console.error('Error:', error);
    });
}

function editUser(id) {
    fetch(`/admin/users/${id}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const user = data.data;
            
            document.getElementById('modalTitle').textContent = 'Edit Pengguna';
            document.getElementById('userId').value = user.id;
            document.getElementById('userName').value = user.name;
            document.getElementById('userEmail').value = user.email;
            document.getElementById('userPhone').value = user.phone_number || '';
            document.getElementById('userAddress').value = user.address || '';
            document.getElementById('userBirthDate').value = user.birth_date ? user.birth_date.split('T')[0] : '';
            document.getElementById('userEducation').value = user.education || '';
            document.getElementById('userJapaneseLevel').value = user.japanese_level || '';
            document.getElementById('userMotivation').value = user.motivation || '';
            document.getElementById('userStatus').value = user.status_id;
            
            // Clear password fields for edit
            document.getElementById('userPassword').value = '';
            document.getElementById('userPasswordConfirmation').value = '';
            document.getElementById('passwordRequired').style.display = 'none';
            document.getElementById('confirmPasswordRequired').style.display = 'none';
            document.getElementById('passwordHelp').textContent = 'Kosongkan jika tidak ingin mengubah password';
            
            // Set roles
            document.querySelectorAll('input[name="roles[]"]').forEach(checkbox => {
                checkbox.checked = user.roles.some(role => role.id == checkbox.value);
            });
            
            document.getElementById('userModal').style.display = 'flex';
        }
    })
    .catch(error => {
        showAlert('error', 'Gagal memuat data pengguna');
        console.error('Error:', error);
    });
}

function viewUser(id) {
    fetch(`/admin/users/${id}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const user = data.data;
            const content = generateUserDetailHTML(user);
            document.getElementById('userDetailContent').innerHTML = content;
            document.getElementById('detailModal').style.display = 'flex';
        }
    })
    .catch(error => {
        showAlert('error', 'Gagal memuat detail pengguna');
        console.error('Error:', error);
    });
}

function deleteUser(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        fetch(`/admin/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', data.message || 'Gagal menghapus pengguna');
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan jaringan');
            console.error('Error:', error);
        });
    }
}

// Filter Functions
function applyFilters() {
    const params = new URLSearchParams();
    
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const role = document.getElementById('roleFilter').value;
    const japaneseLevel = document.getElementById('japaneseLevelFilter').value;
    
    if (search) params.append('search', search);
    if (status) params.append('status_id', status);
    if (role) params.append('role_id', role);
    if (japaneseLevel) params.append('japanese_level', japaneseLevel);
    
    window.location.href = `${window.location.pathname}?${params.toString()}`;
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('roleFilter').value = '';
    document.getElementById('japaneseLevelFilter').value = '';
    
    window.location.href = window.location.pathname;
}

// Bulk Actions
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.user-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    
    if (checkedBoxes.length > 0) {
        bulkDeleteBtn.style.display = 'block';
    } else {
        bulkDeleteBtn.style.display = 'none';
    }
}

function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        showAlert('warning', 'Pilih pengguna yang ingin dihapus');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${ids.length} pengguna?`)) {
        fetch('/admin/users/bulk-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', data.message || 'Gagal menghapus pengguna');
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan jaringan');
            console.error('Error:', error);
        });
    }
}

// Export
function exportUsers() {
    const params = new URLSearchParams(window.location.search);
    window.open(`/admin/users/export?${params.toString()}`, '_blank');
}

// Utility Functions
function showLoading(show) {
    const spinner = document.querySelector('#saveBtn .spinner-border');
    const saveBtn = document.getElementById('saveBtn');
    
    if (show) {
        spinner.style.display = 'inline-block';
        saveBtn.disabled = true;
    } else {
        spinner.style.display = 'none';
        saveBtn.disabled = false;
    }
}

function showAlert(type, message) {
    // You can implement toast notifications here
    // For now, using simple alert
    if (type === 'success') {
        alert('✓ ' + message);
    } else if (type === 'error') {
        alert('✗ ' + message);
    } else {
        alert(message);
    }
}

function clearFormErrors() {
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

}

function showFormErrors(errors) {
    Object.keys(errors).forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = errors[field][0];
            }
        }
    });
}
function generateUserDetailHTML(user) {
    const paymentStatus = user.has_completed_booking_payment ? 
        '<span class="badge badge-success"><i class="fas fa-check"></i> Lunas</span>' :
        '<span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>';
    
    const meetingStatus = user.active_google_meeting ? 
        '<span class="badge badge-success"><i class="fas fa-video"></i> Ada Meeting</span>' :
        '<span class="text-muted">Tidak ada meeting</span>';
    
    return `
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="avatar bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px; font-size: 2rem;">
                    ${user.name.substring(0, 2).toUpperCase()}
                </div>
                <h5>${user.name}</h5>
                <p class="text-muted">${user.email}</p>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <strong>Telepon:</strong><br>
                        ${user.phone_number || '-'}
                    </div>
                    <div class="col-sm-6 mb-3">
                        <strong>Tanggal Lahir:</strong><br>
                        ${user.birth_date ? new Date(user.birth_date).toLocaleDateString('id-ID') : '-'}
                    </div>
                    <div class="col-sm-12 mb-3">
                        <strong>Alamat:</strong><br>
                        ${user.address || '-'}
                    </div>
                    <div class="col-sm-6 mb-3">
                        <strong>Pendidikan:</strong><br>
                        ${user.education || '-'}
                    </div>
                    <div class="col-sm-6 mb-3">
                        <strong>Level Bahasa Jepang:</strong><br>
                        ${user.japanese_level_text || '-'}
                    </div>
                    <div class="col-sm-12 mb-3">
                        <strong>Motivasi:</strong><br>
                        ${user.motivation || '-'}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Status:</strong><br>
                        <span class="badge badge-${user.status && user.status.name === 'Active' ? 'success' : 'warning'}">
                            ${user.status ? user.status.name : '-'}
                        </span>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Payment Status:</strong><br>
                        ${paymentStatus}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Meeting Status:</strong><br>
                        ${meetingStatus}
                    </div>
                    <div class="col-sm-12 mb-3">
                        <strong>Roles:</strong><br>
                        ${user.roles ? user.roles.map(role => `<span class="badge badge-info me-1">${role.name}</span>`).join('') : '-'}
                    </div>
                    <div class="col-sm-6 mb-3">
                        <strong>Dibuat:</strong><br>
                        ${user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID') : '-'}
                    </div>
                    <div class="col-sm-6 mb-3">
                        <strong>Diupdate:</strong><br>
                        ${user.updated_at ? new Date(user.updated_at).toLocaleDateString('id-ID') : '-'}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transactions Section -->
        ${user.transactions && user.transactions.length > 0 ? `
            <hr>
            <h6 class="mb-3">Riwayat Transaksi</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${user.transactions.map(transaction => `
                            <tr>
                                <td>${new Date(transaction.created_at).toLocaleDateString('id-ID')}</td>
                                <td>${transaction.type}</td>
                                <td>${transaction.description}</td>
                                <td>
                                    <span class="badge badge-${transaction.status === 'Completed' ? 'success' : 'warning'}">
                                        ${transaction.status}
                                    </span>
                                </td>
                                <td>${transaction.amount ? 'Rp ' + new Intl.NumberFormat('id-ID').format(transaction.amount) : '-'}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        ` : ''}
        
        <!-- Events Section -->
        ${user.events && user.events.length > 0 ? `
            <hr>
            <h6 class="mb-3">Riwayat Event</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Tanggal Mulai</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${user.events.map(event => `
                            <tr>
                                <td>${new Date(event.created_at).toLocaleDateString('id-ID')}</td>
                                <td>${event.type_id === 1 ? 'Intro Meeting' : 'Event'}</td>
                                <td>
                                    <span class="badge badge-${[5, 6].includes(event.status_id) ? 'success' : 'warning'}">
                                        ${event.status_id === 5 ? 'Scheduled' : event.status_id === 6 ? 'Completed' : 'Pending'}
                                    </span>
                                </td>
                                <td>${event.start_date ? new Date(event.start_date).toLocaleDateString('id-ID') : '-'}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        ` : ''}
    `;
}
// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Add change event listeners to checkboxes
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
    
    // Add enter key listener to search input
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });
    
    // Close modal when clicking outside
    document.getElementById('userModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDetailModal();
        }
    });
});

// Auto-refresh statistics (optional)
function refreshStats() {
    fetch('/admin/users/stats', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('totalUsers').textContent = data.total_users;
            document.getElementById('activeUsers').textContent = data.active_users;
            document.getElementById('completedPayment').textContent = data.completed_payment;
            document.getElementById('hasGoogleMeeting').textContent = data.has_google_meeting;
        }
    })
    .catch(error => {
        console.error('Error refreshing stats:', error);
    });
}
</script>
@endpush