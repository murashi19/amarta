@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </h5>
                        <a href="{{ route('users.profile') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.editProfile.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <div class="position-relative d-inline-block">
                                    <div id="photo-preview" class="mb-3">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}?t={{ time() }}" 
                                                alt="Current Photo" class="img-thumbnail" style="width:120px; height:120px; object-fit:cover;">
                                        @else
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow"
                                                style="width: 120px; height: 120px;" id="preview-placeholder">
                                                <i class="fas fa-users text-white" style="font-size: 36px;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <label for="photo" class="btn btn-primary btn-sm">
                                            <i class="fas fa-camera me-2"></i>Ubah Foto
                                        </label>
                                        <input type="file" id="photo" name="photo" class="d-none" accept="image/*">
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        Format: JPG, JPEG, PNG. Maksimal 5MB.
                                    </small>
                                </div>
                                @error('photo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" 
                                       name="phone_number" 
                                       value="{{ old('phone_number', $user->phone_number) }}">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Birth Place -->
                            <div class="col-md-6 mb-3">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" 
                                       class="form-control @error('birth_place') is-invalid @enderror" 
                                       id="birth_place" 
                                       name="birth_place" 
                                       value="{{ old('birth_place', $user->birth_place) }}">
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Birth Date -->
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" 
                                    class="form-control @error('birth_date') is-invalid @enderror" 
                                    id="birth_date" 
                                    name="birth_date" 
                                    value="{{ old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Education Level -->
                            <div class="col-md-6 mb-3">
                                <label for="education_level" class="form-label">Tingkat Pendidikan</label>
                                <select class="form-select @error('education_level') is-invalid @enderror" id="education_level" name="education_level">
                                    <option value="">Pilih Tingkat Pendidikan</option>
                                    <option value="SMP/Sederajat" {{ old('education_level', $user->education_level) == 'SMP/Sederajat' ? 'selected' : '' }}>
                                        SMP/Sederajat
                                    </option>
                                    <option value="SMA/SMK/Sederajat" {{ old('education_level', $user->education_level) == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>
                                        SMA/SMK/Sederajat
                                    </option>
                                    <option value="Diploma 3 (D3)" {{ old('education_level', $user->education_level) == 'Diploma 3 (D3)' ? 'selected' : '' }}>
                                        Diploma 3 (D3)
                                    </option>
                                    <option value="Sarjana (S1)" {{ old('education_level', $user->education_level) == 'Sarjana (S1)' ? 'selected' : '' }}>
                                        Sarjana (S1)
                                    </option>
                                    <option value="Lainnya" {{ old('education_level', $user->education_level) == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>
                                @error('education_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="3">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.editProfile') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const previewImage = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');
    
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImage) {
                    previewImage.src = e.target.result;
                } else {
                    // Create new image element if placeholder exists
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'rounded-circle shadow';
                    newImg.style.width = '120px';
                    newImg.style.height = '120px';
                    newImg.style.objectFit = 'cover';
                    newImg.id = 'preview-image';
                    
                    previewPlaceholder.replaceWith(newImg);
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.5rem;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    
    .form-control, .form-select {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .btn {
        border-radius: 0.375rem;
        font-weight: 500;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
</style>
@endpush
@endsection
                     