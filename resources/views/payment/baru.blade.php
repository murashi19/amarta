@extends('layouts.dashboard')

@section('title', 'Buat Transaksi Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Buat Transaksi Pembayaran</h1>
                    <p class="text-muted mb-0">Pilih jenis biaya dan metode pembayaran</p>
                </div>
                <a href="{{ route('dashboard.users') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Payment Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-credit-card me-2"></i>Form Pembayaran
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('payments.baru.store') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                        @csrf
                        
                        <!-- Fee Selection -->
                        <div class="mb-4">
                            <label for="fee_id" class="form-label fw-bold">
                                <i class="fas fa-money-bill-wave me-2 text-success"></i>Jenis Biaya
                            </label>
                            <select class="form-select @error('fee_id') is-invalid @enderror" 
                                    id="fee_id" name="fee_id" required {{ count($fees) === 1 ? 'readonly' : '' }}>
                                <option value="">-- Pilih Jenis Biaya --</option>
                                @foreach($fees as $fee)
                                    <option value="{{ $fee->id }}" 
                                            data-amount="{{ number_format($fee->amount, 0, ',', '.') }}"
                                            data-installment="{{ $fee->is_installment_available }}"
                                            data-installment-amount="{{ $fee->installment_amount ? number_format($fee->installment_amount, 0, ',', '.') : 0 }}"
                                            data-installment-months="{{ $fee->installment_months }}"
                                            data-description="{{ $fee->description }}"
                                            {{ old('fee_id', count($fees) === 1 ? $fee->id : '') == $fee->id ? 'selected' : '' }}>
                                        {{ $fee->name }} - Rp {{ number_format($fee->amount, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fee Details Display -->
                        <div id="feeDetails" class="alert alert-info d-none mb-4">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Detail Biaya
                            </h6>
                            <div id="feeDescription"></div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Total Biaya:</strong>
                                    <div class="h5 text-primary" id="totalAmount">Rp 0</div>
                                </div>
                                <div class="col-md-6" id="installmentInfo" style="display: none;">
                                    <strong>Opsi Cicilan:</strong>
                                    <div class="text-success" id="installmentDetails"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Installment Option (if available) -->
                        <div id="installmentOption" class="mb-4 d-none">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar-alt me-2 text-warning"></i>Pilih Pembayaran
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-success">
                                        <div class="card-body text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" 
                                                       name="payment_type" id="fullPayment" value="full" checked>
                                                <label class="form-check-label fw-bold text-success" for="fullPayment">
                                                    <i class="fas fa-money-bill-wave me-2"></i>Bayar Lunas
                                                </label>
                                            </div>
                                            <small class="text-muted">Bayar sekaligus tanpa cicilan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-warning">
                                        <div class="card-body text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" 
                                                       name="payment_type" id="installmentPayment" value="installment">
                                                <label class="form-check-label fw-bold text-warning" for="installmentPayment">
                                                    <i class="fas fa-calendar-check me-2"></i>Bayar Cicilan
                                                </label>
                                            </div>
                                            <small class="text-muted">Bayar dengan sistem cicilan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="mb-4">
                            <label for="payment_method_id" class="form-label fw-bold">
                                <i class="fas fa-university me-2 text-info"></i>Pilih Metode Pembayaran
                            </label>
                            <div class="row">
                                <!-- Bank Transfer Options -->
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 payment-method-card" data-method="1">
                                        <div class="card-body text-center">
                                            <i class="fas fa-university fa-2x text-primary mb-2"></i>
                                            <h6 class="card-title">BCA</h6>
                                            <p class="card-text small text-muted">1234567890</p>
                                            <p class="card-text small">LPK Amarta Bangun Indonesia</p>
                                            <div class="form-check">
                                                <input class="form-check-input @error('payment_method_id') is-invalid @enderror" 
                                                       type="radio" name="payment_method_id" 
                                                       id="method_1" value="1" required>
                                                <label class="form-check-label fw-bold" for="method_1">
                                                    Pilih BCA
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 payment-method-card" data-method="2">
                                        <div class="card-body text-center">
                                            <i class="fas fa-university fa-2x text-warning mb-2"></i>
                                            <h6 class="card-title">BNI</h6>
                                            <p class="card-text small text-muted">9876543210</p>
                                            <p class="card-text small">LPK Amarta Bangun Indonesia</p>
                                            <div class="form-check">
                                                <input class="form-check-input @error('payment_method_id') is-invalid @enderror" 
                                                       type="radio" name="payment_method_id" 
                                                       id="method_2" value="2" required>
                                                <label class="form-check-label fw-bold" for="method_2">
                                                    Pilih BNI
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 payment-method-card" data-method="3">
                                        <div class="card-body text-center">
                                            <i class="fas fa-university fa-2x text-success mb-2"></i>
                                            <h6 class="card-title">Mandiri</h6>
                                            <p class="card-text small text-muted">555666777</p>
                                            <p class="card-text small">LPK Amarta Bangun Indonesia</p>
                                            <div class="form-check">
                                                <input class="form-check-input @error('payment_method_id') is-invalid @enderror" 
                                                       type="radio" name="payment_method_id" 
                                                       id="method_3" value="3" required>
                                                <label class="form-check-label fw-bold" for="method_3">
                                                    Pilih Mandiri
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('payment_method_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    Saya menyetujui <a href="#" class="text-primary">syarat dan ketentuan</a> 
                                    yang berlaku untuk transaksi ini
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                <i class="fas fa-paper-plane me-2"></i>Buat Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="alert alert-warning mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>Penting!
                </h6>
                <ul class="mb-0">
                    <li>Transaksi akan kedaluwarsa dalam <strong>10 menit</strong> setelah dibuat</li>
                    <li>Pastikan data yang Anda masukkan sudah benar</li>
                    <li>Simpan bukti pembayaran untuk verifikasi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.payment-method-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.payment-method-card.selected {
    border-color: #0d6efd;
    background-color: #f8f9ff;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary {
    background: linear-gradient(45deg, #0d6efd, #0056b3);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(13,110,253,0.3);
}

.btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.alert-info {
    background: linear-gradient(45deg, #e3f2fd, #bbdefb);
    border-left: 4px solid #2196f3;
}

.alert-warning {
    background: linear-gradient(45deg, #fff3e0, #ffe0b2);
    border-left: 4px solid #ff9800;
}

.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
    background: linear-gradient(45deg, #0d6efd, #0056b3) !important;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 15px;
    }
    
    .payment-method-card {
        margin-bottom: 15px;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const feeSelect = document.getElementById('fee_id');
        if (!feeSelect) return; // amankan kalau nggak ada elemen fee

        const feeDetails = document.getElementById('feeDetails');
        const feeDescription = document.getElementById('feeDescription');
        const totalAmount = document.getElementById('totalAmount');
        const installmentOption = document.getElementById('installmentOption');
        const installmentInfo = document.getElementById('installmentInfo');
        const installmentDetails = document.getElementById('installmentDetails');
        const paymentSummary = document.getElementById('paymentSummary');
        const agreeTerms = document.getElementById('agreeTerms');
        const submitBtn = document.getElementById('submitBtn');
        const paymentMethodCards = document.querySelectorAll('.payment-method-card');
        const paymentMethodInputs = document.querySelectorAll('input[name="payment_method_id"]');
        const paymentTypeInputs = document.querySelectorAll('input[name="payment_type"]');

        // Fee selection change handler
        feeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                const amount = selectedOption.getAttribute('data-amount');
                const description = selectedOption.getAttribute('data-description');
                const hasInstallment = selectedOption.getAttribute('data-installment') === '1';
                const installmentAmount = selectedOption.getAttribute('data-installment-amount');
                const installmentMonths = selectedOption.getAttribute('data-installment-months');

                // Show fee details
                feeDetails.classList.remove('d-none');
                feeDescription.textContent = description;
                totalAmount.textContent = `Rp ${amount}`;

                // Show/hide installment option
                if (hasInstallment) {
                    installmentOption.classList.remove('d-none');
                    installmentInfo.style.display = 'block';
                    installmentDetails.innerHTML = `Rp ${installmentAmount} x ${installmentMonths} bulan`;
                } else {
                    installmentOption.classList.add('d-none');
                    installmentInfo.style.display = 'none';
                    document.getElementById('fullPayment').checked = true;
                }

                updatePaymentSummary();
            } else {
                feeDetails.classList.add('d-none');
                installmentOption.classList.add('d-none');
                paymentSummary.classList.add('d-none');
            }
            
            checkFormValidity();
        });

        // Payment method card selection
        paymentMethodCards.forEach(card => {
            card.addEventListener('click', function() {
                const methodId = this.getAttribute('data-method');
                const radioInput = document.getElementById(`method_${methodId}`);
                paymentMethodCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                radioInput.checked = true;
                updatePaymentSummary();
                checkFormValidity();
            });
        });

        // Payment type change handler
        paymentTypeInputs.forEach(input => {
            input.addEventListener('change', updatePaymentSummary);
        });

        // Terms checkbox handler
        agreeTerms.addEventListener('change', checkFormValidity);

        function updatePaymentSummary() {
            const selectedFee = feeSelect.options[feeSelect.selectedIndex];
            const selectedPaymentMethod = document.querySelector('input[name="payment_method_id"]:checked');
            const selectedPaymentType = document.querySelector('input[name="payment_type"]:checked');

            if (selectedFee && selectedFee.value && selectedPaymentMethod) {
                const feeName = selectedFee.text.split(' - ')[0];
                const amount = selectedFee.getAttribute('data-amount');
                const installmentAmount = selectedFee.getAttribute('data-installment-amount');
                const paymentMethodLabel = selectedPaymentMethod.parentElement.querySelector('label').textContent.trim();

                document.getElementById('summaryFeeName').textContent = feeName;
                document.getElementById('summaryPaymentMethod').textContent = paymentMethodLabel;
                
                if (selectedPaymentType && selectedPaymentType.value === 'installment') {
                    document.getElementById('summaryAmount').textContent = `Rp ${amount}`;
                    document.getElementById('summaryInstallmentAmount').textContent = `Rp ${installmentAmount}`;
                    document.getElementById('summaryInstallment').style.display = 'block';
                } else {
                    document.getElementById('summaryAmount').textContent = `Rp ${amount}`;
                    document.getElementById('summaryInstallment').style.display = 'none';
                }

                paymentSummary.classList.remove('d-none');
            } else {
                paymentSummary.classList.add('d-none');
            }
        }

        function checkFormValidity() {
            const feeSelected = feeSelect.value !== '';
            const paymentMethodSelected = document.querySelector('input[name="payment_method_id"]:checked') !== null;
            const termsAgreed = agreeTerms.checked;
            submitBtn.disabled = !(feeSelected && paymentMethodSelected && termsAgreed);
        }

        // Form submission loading
        document.getElementById('paymentForm').addEventListener('submit', function() {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            submitBtn.disabled = true;
        });

        // Auto-select payment method if clicked
        paymentMethodInputs.forEach(input => {
            input.addEventListener('change', function() {
                paymentMethodCards.forEach(card => card.classList.remove('selected'));
                this.closest('.payment-method-card').classList.add('selected');
            });
        });

        // Auto-select fee jika hanya ada satu pilihan
        if (feeSelect.options.length === 2) {
            feeSelect.selectedIndex = 1;
            feeSelect.dispatchEvent(new Event('change'));
        }
    });
</script>

@endsection