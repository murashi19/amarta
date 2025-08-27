<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi - LPK Amarta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset untuk email client compatibility */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px 10px;
            margin: 0;
            line-height: 1.6;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        /* Main container dengan shadow yang elegan */
        .email-container {
            max-width: 550px;
            background: #ffffff;
            margin: 20px auto;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
        }

        /* Header dengan gradient biru LPK Amarta */
        .header {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            padding: 30px 25px;
            text-align: center;
            color: white;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .header-icon {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .header h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        /* Content area */
        .content {
            padding: 35px 30px;
            color: #2c3e50;
        }

        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .greeting strong {
            color: #2196F3;
            font-weight: 600;
        }

        .content p {
            font-size: 16px;
            color: #495057;
            margin-bottom: 16px;
            line-height: 1.7;
        }

        .content p:last-child {
            margin-bottom: 0;
        }

        /* OTP Code styling dengan background box */
        .otp-container {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 2px solid #2196F3;
            border-radius: 16px;
            padding: 25px 20px;
            margin: 30px 0;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.15);
        }

        .otp-container::before {
            content: '\f023';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: #2196F3;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .otp-label {
            font-size: 14px;
            color: #1976D2;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            display: block;
        }

        .otp-code {
            font-size: 32px;
            font-weight: 700;
            color: #1976D2;
            letter-spacing: 8px;
            font-family: 'Courier New', Monaco, 'Lucida Console', monospace;
            text-align: center;
            margin: 15px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.7);
            padding: 15px 20px;
            border-radius: 12px;
            display: inline-block;
            min-width: 280px;
        }

        /* Warning box untuk expiry time */
        .warning-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffc107;
            border-left: 4px solid #f39c12;
            border-radius: 12px;
            padding: 18px 20px;
            margin: 25px 0;
            color: #856404;
            text-align: center;
        }

        .warning-icon {
            color: #f39c12;
            font-size: 20px;
            margin-right: 8px;
            vertical-align: middle;
        }

        .warning-text {
            font-size: 15px;
            font-weight: 500;
            display: inline;
        }

        .warning-text strong {
            color: #d68910;
            font-weight: 700;
        }

        /* Instructions box */
        .instructions {
            background: #f8f9fa;
            border-left: 4px solid #6c757d;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }

        .instructions-title {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }

        .instructions-title i {
            color: #6c757d;
            margin-right: 8px;
        }

        .instructions p {
            font-size: 14px;
            color: #6c757d;
            margin: 8px 0;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        .footer-content {
            font-size: 14px;
            color: #6c757d;
            line-height: 1.5;
        }

        .company-name {
            font-weight: 600;
            color: #2196F3;
        }

        .footer-links {
            margin-top: 15px;
            font-size: 13px;
        }

        .footer-links a {
            color: #2196F3;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Security notice */
        .security-notice {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: 1px solid #17a2b8;
            border-left: 4px solid #138496;
            border-radius: 10px;
            padding: 15px 20px;
            margin: 20px 0;
            font-size: 14px;
            color: #0c5460;
        }

        .security-notice i {
            color: #17a2b8;
            margin-right: 8px;
            font-size: 16px;
        }

        /* Responsive design untuk mobile */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px 5px;
            }

            .email-container {
                margin: 10px auto;
                border-radius: 12px;
            }

            .header {
                padding: 25px 20px;
            }

            .header-icon {
                font-size: 40px;
                margin-bottom: 12px;
            }

            .header h2 {
                font-size: 22px;
            }

            .content {
                padding: 25px 20px;
            }

            .otp-code {
                font-size: 28px;
                letter-spacing: 6px;
                min-width: 240px;
                padding: 12px 15px;
            }

            .otp-container {
                padding: 20px 15px;
                margin: 25px 0;
            }

            .greeting {
                font-size: 16px;
            }

            .content p {
                font-size: 15px;
            }
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .email-container {
                box-shadow: none;
                border: 1px solid #ddd;
                max-width: 100%;
            }

            .header {
                background: #2196F3 !important;
                color: white !important;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .email-container {
                background: #ffffff;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            <i class="fas fa-shield-check header-icon"></i>
            <h2>Verifikasi Akun</h2>
        </div>

        <!-- Content Section -->
        <div class="content">
            <p class="greeting">
                <i class="fas fa-user-circle" style="color: #2196F3; margin-right: 8px;"></i>
                Halo <strong>{{ $name }}</strong>,
            </p>

            <p>
                <i class="fas fa-envelope-open-text" style="color: #17a2b8; margin-right: 8px;"></i>
                Terima kasih telah mendaftar di <strong style="color: #2196F3;">LPK Amarta Bangun Indonesia Cabang Cibitung</strong>. 
                Untuk menyelesaikan proses verifikasi akun Anda, silakan masukkan kode berikut:
            </p>

            <!-- OTP Container -->
            <div class="otp-container">
                <span class="otp-label">
                    <i class="fas fa-key" style="margin-right: 5px;"></i>
                    Kode Verifikasi
                </span>
                <div class="otp-code">{{ $verification_code }}</div>
            </div>
            <!-- Tambahkan Link Verifikasi -->
            <p style="text-align:center; margin: 25px 0;">
                <a href="{{ $verificationUrl }}" 
                style="display: inline-block; padding: 12px 25px; background: #2196F3; color: #fff; font-size: 16px; 
                        font-weight: 600; text-decoration: none; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                    <i class="fas fa-check-circle" style="margin-right:8px;"></i>
                    Klik untuk Verifikasi Akun
                </a>
            </p>

            <!-- Warning Box -->
            <div class="warning-box">
                <i class="fas fa-clock warning-icon"></i>
                <span class="warning-text">
                    <strong>Penting!</strong> Kode ini hanya berlaku selama <strong>15 menit</strong> sejak email ini dikirim.
                </span>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <div class="instructions-title">
                    <i class="fas fa-info-circle"></i>
                    Cara Menggunakan Kode:
                </div>
                <p><i class="fas fa-arrow-right" style="margin-right: 8px; color: #2196F3;"></i> Buka halaman verifikasi di website LPK Amarta</p>
                <p><i class="fas fa-arrow-right" style="margin-right: 8px; color: #2196F3;"></i> Masukkan 6 digit kode di atas</p>
                <p><i class="fas fa-arrow-right" style="margin-right: 8px; color: #2196F3;"></i> Klik tombol "Verifikasi" untuk mengaktifkan akun</p>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <i class="fas fa-shield-alt"></i>
                <strong>Keamanan:</strong> Jangan bagikan kode ini kepada siapa pun. Tim IT LPK Amarta Bangun Indonesia Cabang Cibitung tidak akan pernah meminta kode verifikasi melalui telepon atau media lainnya.
            </div>

            <p style="margin-top: 25px; font-size: 15px;">
                Jika Anda tidak merasa mendaftar di LPK Amarta Bangun Indonesia Cabang Cibitung, silakan abaikan email ini dengan aman.
            </p>

            <p style="color: #2196F3; font-weight: 500;">
                <i class="fas fa-heart" style="color: #e74c3c; margin-right: 5px;"></i>
                Salam hangat,<br>
                <strong>Tim IT LPK Amarta Bangun Indonesia Cabang Cibitung</strong>
            </p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <div class="footer-content">
                &copy; {{ date('Y') }} <span class="company-name">LPK Amarta Bangun Indonesia Cabang Cibitung</span>. Semua hak dilindungi undang-undang.
            </div>
            <div class="footer-links">
                <i class="fas fa-globe" style="margin-right: 5px;"></i>
                <a href="mailto:info@lpkamarta.com">
                    <i class="fas fa-envelope"></i> info@lpkamarta.com
                </a>
                <a href="tel:+6285283123744">
                    <i class="fas fa-phone"></i> +62 852-8312-3744
                </a>
                <a href="https://www.lpkamarta.com">
                    <i class="fas fa-link"></i> www.lpkamarta.com
                </a>
            </div>
        </div>
    </div>
</body>
</html>