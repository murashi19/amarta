@php use Carbon\Carbon; @endphp
@extends('layouts.dashboardAdmin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-edit me-2"></i> Edit Pengguna: {{ $user->name }}</h2>
        <a href="{{ route('admin.usersManage') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="userForm" action="{{ route('admin.editUser.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-3" id="userFormTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button">
                            <i class="fas fa-user me-2"></i>Info Dasar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button">
                            <i class="fas fa-id-card me-2"></i>Info Personal
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button">
                            <i class="fas fa-key me-2"></i>Role & Status
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="userFormTabsContent">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                <div class="form-text">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="08xxxxxxxxxx">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="photo" class="form-label">Foto Profil</label>
                                @if($user->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Current Photo" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                        <div class="form-text">Foto saat ini</div>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                                <div class="form-text">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto</div>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info Tab -->
                    <div class="tab-pane fade" id="personal" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Pilih Gender</option>
                                    <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}">
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                @php
                                    $birthDateValue = old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '');
                                @endphp

                                <input type="date" 
                                    class="form-control @error('birth_date') is-invalid @enderror" 
                                    id="birth_date" 
                                    name="birth_date" 
                                    value="{{ $birthDateValue }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="education_level" class="form-label">Tingkat Pendidikan</label>
                                <select class="form-select @error('education_level') is-invalid @enderror" id="education_level" name="education_level">
                                    <option value="">Pilih Tingkat Pendidikan</option>
                                    <option value="SMP/Sederajat" {{ old('education_level', $user->education_level) == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                                    <option value="SMA/SMK/Sederajat" {{ old('education_level', $user->education_level) == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>SMA/SMK/Sederajat</option>
                                    <option value="Diploma 3 (D3)" {{ old('education_level', $user->education_level) == 'Diploma 3 (D3)' ? 'selected' : '' }}>Diploma 3 (D3)</option>
                                    <option value="Sarjana (S1)" {{ old('education_level', $user->education_level) == 'Sarjana (S1)' ? 'selected' : '' }}>Sarjana (S1)</option>
                                    <option value="Lainnya" {{ old('education_level', $user->education_level) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('education_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" placeholder="Alamat lengkap">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Catatan tambahan tentang user">{{ old('notes', $user->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback"></div>
                            @enderror
                        </div>
                    </div>

                    <!-- Roles & Status Tab -->
                    <div class="tab-pane fade" id="roles" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="status_id" class="form-label">Status User <span class="text-danger">*</span></label>
                                <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                                    <option value="">Pilih Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_id', $user->status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="mt-3">
                            <label class="form-label">Role User <span class="text-danger">*</span></label>
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" 
                                                {{ (collect(old('roles', $user->roles->pluck('id')))->contains($role->id)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback d-block" id="roles-error" style="display: none;"></div>
                            @enderror
                        </div> -->
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <a href="{{ route('admin.usersManage') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection