@extends('layouts.dashboard')

@section('title', 'Keuangan')


@section('content')
@push('styles')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .page-header {
            background: var(--color-primary);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }

        .page-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .page-header .lead {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .summary-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: none;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4a9eff, #667eea);
        }

        .summary-card.booking::before {
            background: linear-gradient(90deg, #ff6b6b, #ee5a52);
        }

        .summary-card.pemantapan::before {
            background: linear-gradient(90deg, #4ecdc4, #44a08d);
        }

        .summary-card.pemberangkatan::before {
            background: linear-gradient(90deg, #f093fb, #f5576c);
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .summary-card .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: linear-gradient(135deg, #4a9eff, #667eea);
            margin-bottom: 1rem;
        }

        .summary-card.booking .card-icon {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        }

        .summary-card.pemantapan .card-icon {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
        }

        .summary-card.pemberangkatan .card-icon {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .summary-card .amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .summary-card .card-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
        }

        .nav-pills .nav-link {
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link:not(.active) {
            background-color: white;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .nav-pills .nav-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #4a9eff, #667eea);
            border: 2px solid transparent;
            color: white;
        }

        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: none;
            overflow: hidden;
        }

        .table-responsive {
            border-radius: 15px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: none;
            font-weight: 600;
            color: #495057;
            padding: 1rem;
            border-bottom: 2px solid #dee2e6;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f1f3f4;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-paid {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .badge-waiting {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn-custom {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-pay {
            background: linear-gradient(135deg, #4a9eff, #667eea);
            color: white;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.6;
        }

        .info-alert {
            border-radius: 15px;
            border: none;
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border-left: 4px solid #2196f3;
        }

        .alert-icon {
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .summary-card .amount {
                font-size: 1.5rem;
            }
            
            .nav-pills .nav-link {
                margin-bottom: 0.5rem;
                margin-right: 0;
                text-align: center;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
        }

        /* Animation */
            .fade-in {
                animation: fadeIn 0.6s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
    </style>
@endpush
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-wallet me-3"></i>Keuangan LPK Amarta</h1>
                    <p class="lead mb-0">Kelola pembayaran program Anda dengan mudah</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="text-white">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ date('d F Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Summary Cards -->
            @php
                $userStatus = Auth::user()->status->name ?? 'Unknown';
                $isDeparturePaid = $userStatus === 'Departure Paid';
            @endphp

            <div class="row mb-4">
                <!-- Total Tagihan -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="summary-card fade-in" style="animation-delay: 0.1s;">
                        <div class="card-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h6 class="card-title">Total Tagihan</h6>
                        <div class="amount">
                            Rp {{ number_format(
                                $isDeparturePaid ? $totalBiaya : ($biayaBooking + $biayaDp),
                                0, ',', '.'
                            ) }}
                        </div>
                        <small class="text-muted">
                            {{ $userClass->classProgram->name ?? 'Program Bahasa Jepang N5' }}
                        </small>
                    </div>
                </div>

                <!-- Program Kelas -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="summary-card fade-in" style="animation-delay: 0.2s;">
                        <div class="card-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h6 class="card-title">Program Kelas</h6>
                        <div class="amount">Rp {{ number_format($biayaDp, 0, ',', '.') }}</div>
                        <small class="text-muted">
                            @if($dpTransaction && $dpTransaction->status == 'Completed')
                                <span class="badge badge-paid">Sudah Dibayar</span>
                            @elseif($bookingTransaction && $bookingTransaction->status == 'Completed')
                                <span class="badge badge-pending">Belum Dibayar</span>
                            @else
                                <span class="badge badge-waiting">Menunggu Booking</span>
                            @endif
                        </small>
                    </div>
                </div>

                <!-- Biaya Pemantapan -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="summary-card fade-in" style="animation-delay: 0.3s;">
                        <div class="card-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h6 class="card-title">Biaya Pemantapan</h6>
                        <div class="amount">
                            {{ $isDeparturePaid ? 'Rp ' . number_format($biayaPemantapan, 0, ',', '.') : 'Rp -' }}
                        </div>
                        <small class="text-muted">
                            {{ $isDeparturePaid ? 'Wajib dibayar sebelum keberangkatan' : 'Tampilkan saat status: Departure Paid' }}
                        </small>
                    </div>
                </div>

                <!-- Biaya Pemberangkatan -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="summary-card fade-in" style="animation-delay: 0.4s;">
                        <div class="card-icon">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <h6 class="card-title">Pemberangkatan</h6>
                        <div class="amount">
                            {{ $isDeparturePaid ? 'Rp ' . number_format($biayaPemberangkatan, 0, ',', '.') : 'Rp -' }}
                        </div>
                        <small class="text-muted">
                            {{ $isDeparturePaid ? 'Segera lakukan pembayaran' : 'Tunggu sampai status: Departure Paid' }}
                        </small>
                    </div>
                </div>
            </div>

        
            <!-- Info Alert -->
            <div class="alert info-alert fade-in" role="alert">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-info-circle alert-icon text-primary"></i>
                    </div>
                    <div class="col">
                        <h5 class="alert-heading mb-2"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h5>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <strong>Total Biaya Program {{ $userClass->classProgram->name ?? 'Bahasa Jepang N5' }}:</strong> 
                                <span class="text-primary fw-bold">
                                    Rp {{ number_format($totalBiaya ?? 15000000, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Sistem Pembayaran Bertahap:</strong>
                                <ul class="mb-0 mt-1">
                                    <li>Booking Class: <span class="fw-bold">Rp {{ number_format($biayaBooking ?? 500000, 0, ',', '.') }}</span></li>
                                    <li>Program Kelas: <span class="fw-bold">Rp {{ number_format($biayaDp ?? 7000000, 0, ',', '.') }}</span></li>
                                    <li>Biaya Pemantapan: 
                                        <span class="fw-bold">
                                            @if(($user->status->name ?? '') === 'Departure Paid')
                                                Rp {{ number_format($biayaPemantapan ?? 20000000, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </li>
                                    <li>Biaya Pemberangkatan: 
                                        <span class="fw-bold">
                                            @if(($user->status->name ?? '') === 'Departure Paid')
                                                Rp {{ number_format($biayaPemberangkatan ?? 35000000, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        <!-- Navigation Tabs -->
        <div class="row mb-4">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center flex-wrap" id="paymentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tagihan-tab" data-bs-toggle="pill" data-bs-target="#tagihan" type="button">
                            <i class="fas fa-list-alt me-2"></i>Ringkasan Tagihan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="booking-tab" data-bs-toggle="pill" data-bs-target="#booking" type="button">
                            <i class="fas fa-bookmark me-2"></i>Booking Class
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="programkelas-tab" data-bs-toggle="pill" data-bs-target="#programkelas" type="button">
                            <i class="fas fa-book-open me-2"></i>Program Kelas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pemantapan-tab" data-bs-toggle="pill" data-bs-target="#pemantapan" type="button">
                            <i class="fas fa-graduation-cap me-2"></i>Pemantapan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pemberangkatan-tab" data-bs-toggle="pill" data-bs-target="#pemberangkatan" type="button">
                            <i class="fas fa-plane-departure me-2"></i>Pemberangkatan
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="paymentTabsContent">
            <!-- Ringkasan Tagihan Tab -->
            <div class="tab-pane fade show active" id="tagihan" role="tabpanel">
                <div class="card table-card">
                    <div class="card-header bg-transparent border-0 p-3">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Ringkasan Semua Tagihan</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-2"></i>No</th>
                                    <th><i class="fas fa-tag me-2"></i>Jenis Pembayaran</th>
                                    <th><i class="fas fa-money-bill-wave me-2"></i>Jumlah</th>
                                    <th><i class="fas fa-calendar me-2"></i>Jatuh Tempo</th>
                                    <th><i class="fas fa-info-circle me-2"></i>Status</th>
                                    <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 1. Booking Class -->
                                <tr>
                                    <td><span class="badge bg-primary">1</span></td>
                                    <td>
                                        <div>
                                            <strong>Booking Class</strong>
                                            <br><small class="text-muted">Mengamankan tempat di program</small>
                                        </div>
                                    </td>
                                    <td><strong class="text-primary">Rp {{ number_format($biayaBooking ?? 500000, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ date('d/m/Y', strtotime('+10 days')) }}
                                    </td>
                                    <td>
                                        @if($bookingTransaction && $bookingTransaction->status == 'Completed')
                                            <span class="badge badge-paid"><i class="fas fa-check me-1"></i>Lunas</span>
                                        @else
                                            <span class="badge badge-pending"><i class="fas fa-clock me-1"></i>Belum Dibayar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$bookingTransaction || $bookingTransaction->status != 'Completed')
                                            <a href="#" class="btn btn-custom btn-pay btn-sm">
                                                <i class="fas fa-credit-card me-1"></i>Bayar
                                            </a>
                                        @else
                                            <span class="btn btn-custom btn-success-custom btn-sm">
                                                <i class="fas fa-check me-1"></i>Lunas
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                                <!-- 2. Program Kelas -->
                                <tr>
                                    <td><span class="badge bg-info">2</span></td>
                                    <td>
                                        <div>
                                            <strong>Program Kelas</strong>
                                            <br><small class="text-muted">Biaya pelatihan dan materi</small>
                                        </div>
                                    </td>
                                    <td><strong class="text-info">Rp {{ number_format($biayaDp ?? 7000000, 0, ',', '.') }}</strong></td>
                                    <td>
                                        @if($bookingTransaction && $bookingTransaction->status == 'Completed')
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ date('d/m/Y', strtotime('+30 days')) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($dpTransaction && $dpTransaction->status == 'Completed')
                                            <span class="badge badge-paid"><i class="fas fa-check me-1"></i>Lunas</span>
                                        @elseif($bookingTransaction && $bookingTransaction->status == 'Completed')
                                            <span class="badge badge-pending"><i class="fas fa-clock me-1"></i>Belum Dibayar</span>
                                        @else
                                            <span class="badge badge-waiting"><i class="fas fa-hourglass-half me-1"></i>Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($bookingTransaction && $bookingTransaction->status == 'Completed')
                                            @if($dpTransaction && $dpTransaction->status != 'Completed')
                                                <a href="{{ route('transaksi.programKelas', ['id' => $dpTransaction->id]) }}" class="btn btn-custom btn-pay btn-sm">
                                                    <i class="fas fa-credit-card me-1"></i>Bayar
                                                </a>
                                            @elseif(!$dpTransaction)
                                                <a href="{{ route('transaksi.programKelas.createProgramKelas') }}" class="btn btn-custom btn-pay btn-sm">
                                                    <i class="fas fa-credit-card me-1"></i>Bayar
                                                </a>
                                            @else
                                                <span class="btn btn-custom btn-success-custom btn-sm">
                                                    <i class="fas fa-check me-1"></i>Lunas
                                                </span>
                                            @endif
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                <i class="fas fa-lock me-1"></i>Terkunci
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- 3. Biaya Pemantapan -->
                                <tr>
                                    <td><span class="badge bg-secondary">3</span></td>
                                    <td>
                                        <div>
                                            <strong>Biaya Pemantapan</strong>
                                            <br><small class="text-muted">MCU, Passport, Kontrak, Dokumen</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-secondary">
                                            @if(($user->status->name ?? '') === 'Departure Paid')
                                                Rp {{ number_format($biayaPemantapan ?? 20000000, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </strong>
                                    </td>
                                    <td>
                                        @if($dpTransaction && $dpTransaction->status == 'Completed')
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ date('d/m/Y', strtotime('+45 days')) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pemantapanPaid)
                                            <span class="badge badge-paid"><i class="fas fa-check me-1"></i>Lunas</span>
                                        @elseif($dpTransaction && $dpTransaction->status == 'Completed')
                                            <span class="badge badge-pending"><i class="fas fa-clock me-1"></i>Belum Dibayar</span>
                                        @else
                                            <span class="badge badge-waiting"><i class="fas fa-hourglass-half me-1"></i>Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($dpTransaction && $dpTransaction->status == 'Completed' && !$pemantapanPaid)
                                            <a href="#" class="btn btn-custom btn-pay btn-sm">
                                                <i class="fas fa-credit-card me-1"></i>Bayar
                                            </a>
                                        @elseif($pemantapanPaid)
                                            <span class="btn btn-custom btn-success-custom btn-sm">
                                                <i class="fas fa-check me-1"></i>Lunas
                                            </span>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                <i class="fas fa-lock me-1"></i>Terkunci
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- 4. Biaya Pemberangkatan -->
                                <tr>
                                    <td><span class="badge bg-warning">4</span></td>
                                    <td>
                                        <div>
                                            <strong>Biaya Pemberangkatan</strong>
                                            <br><small class="text-muted">Tiket, Visa & Keperluan Jepang</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-warning">
                                            @if(($user->status->name ?? '') === 'Departure Paid')
                                                Rp {{ number_format($biayaPemberangkatan ?? 35000000, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </strong>
                                    </td>
                                    <td>
                                        @if($pemantapanPaid)
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ date('d/m/Y', strtotime('+60 days')) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pemberangkatanPaid)
                                            <span class="badge badge-paid"><i class="fas fa-check me-1"></i>Lunas</span>
                                        @elseif($pemantapanPaid)
                                            <span class="badge badge-pending"><i class="fas fa-clock me-1"></i>Belum Dibayar</span>
                                        @else
                                            <span class="badge badge-waiting"><i class="fas fa-hourglass-half me-1"></i>Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pemantapanPaid && !$pemberangkatanPaid)
                                            <a href="#" class="btn btn-custom btn-pay btn-sm">
                                                <i class="fas fa-credit-card me-1"></i>Bayar
                                            </a>
                                        @elseif($pemberangkatanPaid)
                                            <span class="btn btn-custom btn-success-custom btn-sm">
                                                <i class="fas fa-check me-1"></i>Lunas
                                            </span>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                <i class="fas fa-lock me-1"></i>Terkunci
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Konten Booking Class Tab -->
            <div class="tab-pane fade" id="programkelas" role="tabpanel">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card table-card">
                        <div class="card-body text-center">
                            <div class="card-icon mx-auto mb-3" style="background: linear-gradient(135deg, #4ecdc4, #44a08d);">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h5>Program Kelas Bahasa</h5>
                            <h3 class="text-info">
                                Rp {{ number_format($biayaDp ?? 7000000, 0, ',', '.') }}
                            </h3>
                            <p class="text-muted">
                                Status: 
                                @if($dpTransaction && $dpTransaction->status == 'Completed')
                                    <span class="badge badge-paid">Sudah Dibayar</span>
                                @elseif($bookingTransaction && $bookingTransaction->status == 'Completed')
                                    <span class="badge badge-pending">Belum Lunas</span>
                                @else
                                    <span class="badge badge-waiting">Menunggu Booking</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mb-4">
                    <div class="alert info-alert">
                        <h6><i class="fas fa-info-circle me-2"></i>Informasi Program Kelas</h6>
                        <ul class="mb-0">
                            <li>Pembayaran bisa dilakukan dengan DP atau cicilan</li>
                            <li>Total biaya: Rp {{ number_format($biayaDp ?? 7000000, 0, ',', '.') }}</li>
                            <li>Akses penuh diberikan setelah pembayaran selesai</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if($bookingTransaction && $bookingTransaction->status == 'Completed')
                {{-- Tabel Transaksi Program Kelas --}}
                <div class="card table-card mb-4">
                    <div class="card-header bg-transparent border-0 p-3">
                        <h5 class="mb-0"><i class="fas fa-book-open me-2"></i>Detail Program Kelas</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>Program Kelas - {{ $userClass->classProgram->name ?? 'Bahasa Jepang N5' }}</strong>
                                        <br><small>Biaya pelatihan & materi pembelajaran</small>
                                    </td>
                                    <td><strong class="text-info">Rp {{ number_format($dpTransaction->amount ?? $biayaDp ?? 7000000, 0, ',', '.') }}</strong></td>
                                    <td>
                                        @if($dpTransaction && $dpTransaction->status == 'Completed')
                                            <span class="badge badge-paid">Lunas</span>
                                        @else
                                            <span class="badge badge-pending">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$dpTransaction || $dpTransaction->status != 'Completed')
                                            <a href="{{ route('transaksi.programKelas', ['id' => $dpTransaction->id]) }}" class="btn btn-custom btn-pay btn-sm">
                                                <i class="fas fa-credit-card me-1"></i>Bayar / Cicilan
                                            </a>
                                        @else
                                            <span class="btn btn-custom btn-success-custom btn-sm">
                                                <i class="fas fa-check me-1"></i>Lunas
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Riwayat Cicilan --}}
                @if(isset($feePayments) && count($feePayments) > 0)
                    <div class="card table-card">
                        <div class="card-header bg-transparent border-0 p-3">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Riwayat Cicilan</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feePayments as $cicilan)
                                        <tr>
                                            <td>{{ $cicilan->created_at->format('d/m/Y H:i') }}</td>
                                            <td>Rp {{ number_format($cicilan->amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if($cicilan->status == 'Completed')
                                                    <span class="badge badge-paid">Lunas</span>
                                                @else
                                                    <span class="badge badge-pending">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($cicilan->photo)
                                                    <a href="{{ asset('storage/'.$cicilan->photo) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <h4>Program Kelas Belum Tersedia</h4>
                    <p>Silahkan selesaikan pembayaran Booking Class terlebih dahulu</p>
                </div>
            @endif
        </div>


            <!-- Konten Pemantapan Tab -->
            <div class="tab-pane fade" id="pemantapan" role="tabpanel">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card table-card">
                            <div class="card-body text-center">
                                <div class="card-icon mx-auto mb-3" style="background: linear-gradient(135deg, #4ecdc4, #44a08d);">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h5>Biaya Pemantapan</h5>
                                @if($user->status->name === 'Departure Paid')
                                    <h3 class="text-info">Rp {{ number_format($biayaPemantapan ?? 20000000, 0, ',', '.') }}</h3>
                                @else
                                    <h3 class="text-muted">-</h3>
                                @endif
                                <p class="text-muted">
                                    Status: 
                                    @if($pemantapanPaid)
                                        <span class="badge badge-paid">Sudah Dibayar</span>
                                    @elseif($dpTransaction && $dpTransaction->status == 'Completed')
                                        <span class="badge badge-pending">Belum Dibayar</span>
                                    @else
                                        <span class="badge badge-waiting">Menunggu Program Kelas</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 mb-4">
                        <div class="alert info-alert">
                            <h6><i class="fas fa-info-circle me-2"></i>Informasi Biaya Pemantapan</h6>
                            <ul class="mb-0">
                                <li>Biaya ini digunakan untuk: MCU, Passport, Tanda Tangan Kontrak, dan Dokumen Pemberangkatan.</li>
                                <li>Akses tahap akhir akan diberikan setelah pembayaran selesai.</li>
                                @if(!$dpTransaction || $dpTransaction->status !== 'Completed')
                                    <li><strong>Anda harus menyelesaikan Program Kelas terlebih dahulu.</strong></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                @if($dpTransaction && $dpTransaction->status == 'Completed')
                    <div class="card table-card">
                        <div class="card-header bg-transparent border-0 p-3">
                            <h5 class="mb-0"><i class="fas fa-book-open me-2"></i>Detail Biaya Pemantapan</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                                        <th><i class="fas fa-info-circle me-2"></i>Keterangan</th>
                                        <th><i class="fas fa-money-bill-wave me-2"></i>Jumlah</th>
                                        <th><i class="fas fa-flag me-2"></i>Status</th>
                                        <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ $pemantapanTransaction?->paid_at ? $pemantapanTransaction->paid_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td>
                                            <div>
                                                <strong>Pembayaran Pemantapan</strong><br>
                                                <small class="text-muted">MCU, dokumen, passport, dll.</small>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-info">
                                                Rp {{ number_format($pemantapanTransaction->amount ?? $biayaPemantapan ?? 20000000, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                        <td>
                                            @if($pemantapanPaid)
                                                <span class="badge badge-paid"><i class="fas fa-check me-1"></i>Paid</span>
                                            @else
                                                <span class="badge badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$pemantapanPaid)
                                                <a href="#" class="btn btn-custom btn-pay btn-sm">
                                                    <i class="fas fa-credit-card me-1"></i>Bayar
                                                </a>
                                            @elseif($pemantapanTransaction?->xendit_invoice_id)
                                                <a href="#" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-file-invoice me-1"></i>Invoice
                                                </a>
                                            @else
                                                <span class="btn btn-custom btn-success-custom btn-sm">
                                                    <i class="fas fa-check me-1"></i>Lunas
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <h4>Pembayaran Belum Dibuka</h4>
                        <p>Silahkan selesaikan pembayaran Program Kelas terlebih dahulu untuk membuka akses pembayaran Pemantapan.</p>
                        <a href="#" class="btn btn-custom btn-pay" onclick="document.getElementById('programkelas-tab').click()">
                            <i class="fas fa-bookmark me-2"></i>Bayar Program Kelas
                        </a>
                    </div>
                @endif
            </div>

            <!-- Konten Tab Pemberangkatan -->
            <div class="tab-pane fade" id="pemberangkatan" role="tabpanel">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card table-card">
                            <div class="card-body text-center">
                                <div class="card-icon mx-auto mb-3" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                    <i class="fas fa-plane-departure"></i>
                                </div>
                                <h5>Biaya Pemberangkatan</h5>

                                @if(($user->status->name ?? '') === 'Departure Paid')
                                    <h3 class="text-warning">
                                        Rp {{ number_format($biayaPemberangkatan ?? 35000000, 0, ',', '.') }}
                                    </h3>
                                @else
                                    <h3 class="text-warning">-</h3>
                                @endif

                                <p class="text-muted">
                                    Status: 
                                    @if($pemantapanTransaction && $pemantapanTransaction->status == 'Completed')
                                        @if($pemberangkatanPaid)
                                            <span class="badge badge-paid">Sudah Dibayar</span>
                                        @else
                                            <span class="badge badge-pending">Belum Dibayar</span>
                                        @endif
                                    @else
                                        <span class="badge badge-waiting">Menunggu Pemantapan</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 mb-4">
                        <div class="alert info-alert">
                            <h6><i class="fas fa-info-circle me-2"></i>Informasi Biaya Pemberangkatan</h6>
                            @if($pemantapanTransaction && $pemantapanTransaction->status == 'Completed')
                                <ul class="mb-0">
                                    <li>Biaya pemberangkatan sudah tersedia untuk dibayar</li>
                                    <li>Mencakup tiket pesawat, visa, transportasi, jaket almamater, dan keperluan lainnya</li>
                                    <li>Jadwal keberangkatan akan diinformasikan setelah pembayaran</li>
                                </ul>
                            @else
                                <ul class="mb-0">
                                    <li>Biaya tersedia setelah menyelesaikan pembayaran Pemantapan</li>
                                    <li>Digunakan untuk keperluan keberangkatan ke Jepang</li>
                                    <li>Harap selesaikan semua pembayaran sebelumnya terlebih dahulu</li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                @if($pemantapanTransaction && $pemantapanTransaction->status == 'Completed')
                    <div class="card table-card">
                        <div class="card-header bg-transparent border-0 p-3">
                            <h5 class="mb-0"><i class="fas fa-plane-departure me-2"></i>Detail Biaya Pemberangkatan</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                                        <th><i class="fas fa-info-circle me-2"></i>Keterangan</th>
                                        <th><i class="fas fa-money-bill-wave me-2"></i>Jumlah</th>
                                        <th><i class="fas fa-flag me-2"></i>Status</th>
                                        <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $pemberangkatanTransaction->paid_at?->format('d/m/Y H:i') ?? date('d/m/Y') }}</td>
                                        <td>
                                            <div>
                                                <strong>Pemberangkatan - {{ $userClass->classProgram->name ?? 'Program Bahasa Jepang N5' }}</strong>
                                                <br><small class="text-muted">Tiket, visa, transportasi, dan keperluan keberangkatan</small>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-warning">
                                                Rp {{ number_format($pemberangkatanTransaction->amount ?? $biayaPemberangkatan ?? 35000000, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                        <td>
                                            @if($pemberangkatanPaid)
                                                <span class="badge badge-paid"><i class="fas fa-check me-1"></i>Paid</span>
                                            @else
                                                <span class="badge badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$pemberangkatanPaid)
                                                <a href="#" class="btn btn-custom btn-pay btn-sm">
                                                    <i class="fas fa-credit-card me-1"></i>Bayar
                                                </a>
                                            @else
                                                @if($pemberangkatanTransaction->xendit_invoice_id)
                                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-file-invoice me-1"></i>Invoice
                                                    </a>
                                                @else
                                                    <span class="btn btn-custom btn-success-custom btn-sm">
                                                        <i class="fas fa-check me-1"></i>Lunas
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <h4>Biaya Pemberangkatan Belum Tersedia</h4>
                        <p>Silahkan selesaikan pembayaran Pemantapan terlebih dahulu untuk membuka akses pembayaran biaya pemberangkatan</p>
                        <a href="#" class="btn btn-custom btn-pay" onclick="document.getElementById('pemantapan-tab').click()">
                            <i class="fas fa-book-open me-2"></i>Lihat Biaya Pemantapan
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <!-- Modal konfirmasi Bootstrap -->
    <div class="modal fade" id="confirmPaymentModal" tabindex="-1" aria-labelledby="confirmPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmPaymentModalLabel">Konfirmasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin melakukan pembayaran sebesar <strong id="modalAmount">jumlah tertentu</strong>?
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" id="confirmPaymentBtn">Ya, Bayar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Animate cards on page load
        const fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach((element, index) => {
            setTimeout(() => {
                element.style.animationDelay = (index * 0.1) + 's';
                element.classList.add('fade-in');
            }, 100);
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Hover card effect
        const cards = document.querySelectorAll('.summary-card, .table-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'all 0.3s ease';
            });
            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
            });
        });

        // Progress indicator
        function updateProgressIndicator() {
            const bookingCompleted = {{ (isset($bookingTransaction) && $bookingTransaction->status == 'Completed') ? 'true' : 'false' }};
            const dpCompleted = {{ (isset($dpTransaction) && $dpTransaction->status == 'Completed') ? 'true' : 'false' }};
            const progressSteps = document.querySelectorAll('.progress-step');
            if (progressSteps.length > 0) {
                if (bookingCompleted) progressSteps[0].classList.add('completed');
                if (dpCompleted) progressSteps[1].classList.add('completed');
            }
        }
        updateProgressIndicator();

        // Tooltips
        const statusBadges = document.querySelectorAll('.badge-status');
        statusBadges.forEach(badge => {
            let tooltipText = '';
            if (badge.textContent.includes('Lunas')) tooltipText = 'Pembayaran telah berhasil dikonfirmasi';
            else if (badge.textContent.includes('Pending')) tooltipText = 'Menunggu pembayaran dari Anda';
            else if (badge.textContent.includes('Menunggu')) tooltipText = 'Menunggu tahap pembayaran sebelumnya';
            
            if (tooltipText) {
                badge.setAttribute('data-bs-toggle', 'tooltip');
                badge.setAttribute('data-bs-placement', 'top');
                badge.setAttribute('title', tooltipText);
            }
        });
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

@endpush
@endsection