@extends('layouts.dashboardAdmin')

@section('title', 'Edit Profil Admin')

@section('content')
@push('styles')
    <style>
        :root {
            --color-primary: #0d5ea6;
            --color-secondary: #a6550d;
            --color-success: #24c224;
            --color-warning: #e2b11e;
            --color-danger: #ac2020;
            --color-info: #297ba3;
            --color-light: #eff2f6;
            --color-dark: #162737;
            --color-hover: #d6eafe;
            --color-disabletxt: #9e9e9e;
            --gradient-primary: linear-gradient(135deg, #0d5ea6 0%, #1e7bb8 100%);
            --gradient-light: linear-gradient(135deg, #d6eafe 0%, #e8f4fd 100%);
            --shadow-soft: 0 10px 40px rgba(13, 94, 166, 0.1);
            --shadow-hover: 0 20px 60px rgba(13, 94, 166, 0.2);
            
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --radius: 12px;
            --radius-lg: 16px;
        }

        body {
            background: var(--gradient-light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
        }

        .edit-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .edit-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .edit-header {
            background: var(--gradient-primary);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .edit-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M30 15L45 30L30 45L15 30z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
            opacity: 0.1;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .header-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .form-section {
            padding: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--color-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .section-icon {
            color: var(--color-primary);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--color-dark);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(13, 94, 166, 0.1);
            transform: translateY(-1px);
        }

        .form-control:hover {
            border-color: var(--gray-400);
            background: var(--color-hover);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            padding-right: 2.5rem;
        }

        .photo-upload {
            text-align: center;
            margin-bottom: 2rem;
        }

        .current-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--color-primary);
            margin: 0 auto 1rem;
            display: block;
            transition: all 0.3s ease;
        }

        .photo-placeholder {
            width: 120px;
            height: 120px;
            background: var(--color-light);
            border: 4px solid var(--color-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--color-primary);
            font-size: 2rem;
        }

        .photo-upload-btn {
            background: var(--color-light);
            border: 2px dashed var(--color-primary);
            border-radius: var(--radius);
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .photo-upload-btn:hover {
            border-color: var(--color-primary);
            background: var(--color-hover);
            box-shadow: var(--shadow-soft);
        }

        .photo-upload-btn input[type="file"] {
            position: absolute;
            left: -9999px;
            opacity: 0;
        }

        .upload-content {
            text-align: center;
            color: var(--gray-600);
        }

        .upload-icon {
            font-size: 2rem;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }

        .btn-modern {
            padding: 0.75rem 2rem;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-soft);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-secondary {
            background: white;
            color: var(--color-dark);
            border: 2px solid var(--gray-300);
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--color-light);
            border-color: var(--color-primary);
            transform: translateY(-1px);
            box-shadow: var(--shadow-soft);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            background: var(--color-light);
            border-top: 1px solid var(--gray-200);
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            border: none;
        }

        .alert-danger {
            background: rgba(172, 32, 32, 0.1);
            color: var(--color-danger);
            border-left: 4px solid var(--color-danger);
        }

        .invalid-feedback {
            color: var(--color-danger);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-control.is-invalid {
            border-color: var(--color-danger);
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(172, 32, 32, 0.1);
        }

        .preview-image {
            max-width: 120px;
            max-height: 120px;
            border-radius: 50%;
            margin-top: 1rem;
            border: 4px solid var(--color-primary);
        }

        @media (max-width: 768px) {
            .edit-container {
                padding: 1rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .form-section {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

<div class="edit-container">
    <div class="edit-card">
        <!-- Header -->
        <div class="edit-header">
            <div class="header-content">
                <h1 class="header-title">
                    <i class="fas fa-user-edit"></i>
                    Edit Profil Admin
                </h1>
                <p class="header-subtitle">Perbarui informasi profil administrator</p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.updateProfile') }}" enctype="multipart/form-data">
            @csrf

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan:</h5>
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Photo Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-camera section-icon"></i>
                    Foto Profil
                </h3>
                
                <div class="photo-upload">
                    @if($admin->photo)
                        <img src="{{ Storage::url($admin->photo) }}" 
                             class="current-photo" 
                             alt="Current Photo"
                             id="currentPhoto">
                    @else
                        <div class="photo-placeholder" id="photoPlaceholder">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    @endif

                    <div class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                        <input type="file" 
                               id="photoInput" 
                               name="photo" 
                               accept="image/jpeg,image/jpg,image/png"
                               onchange="previewPhoto(this)">
                        <div class="upload-content">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p style="margin: 0; font-weight: 500;">Klik untuk upload foto baru</p>
                            <small style="color: var(--gray-500);">JPG, JPEG, PNG (Max: 5MB)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user section-icon"></i>
                    Informasi Personal
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap *</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $admin->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $admin->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="form-label">Nomor Telepon</label>
                        <input type="tel" 
                               class="form-control @error('phone_number') is-invalid @enderror" 
                               id="phone_number" 
                               name="phone_number" 
                               value="{{ old('phone_number', $admin->phone_number) }}" 
                               placeholder="Contoh: 08123456789">
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-control form-select @error('gender') is-invalid @enderror" 
                                id="gender" 
                                name="gender">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender', $admin->gender) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('gender', $admin->gender) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="birth_place" class="form-label">Tempat Lahir</label>
                        <input type="text" 
                               class="form-control @error('birth_place') is-invalid @enderror" 
                               id="birth_place" 
                               name="birth_place" 
                               value="{{ old('birth_place', $admin->birth_place) }}" 
                               placeholder="Contoh: Jakarta">
                        @error('birth_place')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="birth_date" class="form-label">Tanggal Lahir</label>
                        <input type="date" 
                               class="form-control @error('birth_date') is-invalid @enderror" 
                               id="birth_date" 
                               name="birth_date" 
                               value="{{ old('birth_date', $admin->birth_date ? $admin->birth_date->format('Y-m-d') : '') }}">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="education_level" class="form-label">Pendidikan Terakhir</label>
                        <select class="form-control form-select @error('education_level') is-invalid @enderror" 
                                id="education_level" 
                                name="education_level">
                            <option value="">Pilih Pendidikan</option>
                            ,'SMA/SMK/Sederajat','Diploma 3 (D3)','Sarjana (S1)','Lainnya'
                            <option value="SMP" {{ old('education_level', $admin->education_level) == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                            <option value="SMA" {{ old('education_level', $admin->education_level) == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>SMA/SMK/Sederajat</option>
                            <option value="D3" {{ old('education_level', $admin->education_level) == 'Diploma 3 (D3)' ? 'selected' : '' }}>Diploma 3 (D3)</option>
                            <option value="S1" {{ old('education_level', $admin->education_level) == 'Sarjana (S1)' ? 'selected' : '' }}>Sarjana (S1)</option>
                        </select>
                        @error('education_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" 
                              name="address" 
                              rows="3" 
                              placeholder="Masukkan alamat lengkap">{{ old('address', $admin->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.profile') }}" class="btn-modern btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Remove existing photo/placeholder
                    const currentPhoto = document.getElementById('currentPhoto');
                    const placeholder = document.getElementById('photoPlaceholder');
                    
                    if (currentPhoto) {
                        currentPhoto.src = e.target.result;
                    } else if (placeholder) {
                        // Replace placeholder with image
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'current-photo';
                        img.id = 'currentPhoto';
                        placeholder.parentNode.replaceChild(img, placeholder);
                    }
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            
            if (!name) {
                e.preventDefault();
                alert('Nama lengkap wajib diisi!');
                document.getElementById('name').focus();
                return;
            }
            
            if (!email) {
                e.preventDefault();
                alert('Email wajib diisi!');
                document.getElementById('email').focus();
                return;
            }
            
            // Email format validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Format email tidak valid!');
                document.getElementById('email').focus();
                return;
            }

            // Phone number validation (if filled)
            const phone = document.getElementById('phone_number').value.trim();
            if (phone && !/^[0-9+\-\s()]+$/.test(phone)) {
                e.preventDefault();
                alert('Format nomor telepon tidak valid!');
                document.getElementById('phone_number').focus();
                return;
            }

            // Show loading state
            const submitBtn = document.querySelector('button[type="submit"]');
            const icon = submitBtn.querySelector('i');
            const text = submitBtn.querySelector('span') || submitBtn.childNodes[1];
            
            icon.className = 'fas fa-spinner fa-spin';
            if (text) text.textContent = ' Menyimpan...';
            submitBtn.disabled = true;
        });

        // Auto-resize textarea
        document.getElementById('address').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });

        // Input formatting
        document.getElementById('phone_number').addEventListener('input', function() {
            // Remove non-numeric characters except +, -, space, ()
            this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
        });

        // Capitalize first letter of name
        document.getElementById('name').addEventListener('blur', function() {
            this.value = this.value.split(' ').map(word => 
                word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
            ).join(' ');
        });

        // Auto capitalize birth place
        document.getElementById('birth_place').addEventListener('blur', function() {
            this.value = this.value.split(' ').map(word => 
                word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
            ).join(' ');
        });
    </script>
@endpush

@endsection