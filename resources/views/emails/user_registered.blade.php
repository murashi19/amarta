<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registrasi Berhasil</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .email-header {
            background: #0d5ea6;
            padding: 30px 20px;
            text-align: center;
        }
        
        .email-header h2 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 300;
        }
        
        .email-body {
            padding: 30px;
        }
        
        .email-body p {
            margin: 0 0 15px 0;
            font-size: 16px;
        }
        
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .info-item {
            margin: 10px 0;
            font-size: 15px;
        }
        
        .info-item strong {
            color: #495057;
            font-weight: 600;
            display: inline-block;
            width: 80px;
        }
        
        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-left: 4px solid #f39c12;
            border-radius: 6px;
            padding: 15px 20px;
            margin: 25px 0;
        }
        
        .warning-box b {
            color: #856404;
            font-size: 16px;
        }
        
        .warning-box p {
            margin: 5px 0 0 0;
            color: #856404;
            font-size: 14px;
        }
        
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
        }
        
        .signature {
            margin: 20px 0 0 0;
            font-size: 15px;
            color: #6c757d;
        }
        
        .signature strong {
            color: #495057;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
            }
            
            .email-header {
                padding: 20px 15px;
            }
            
            .email-body {
                padding: 20px 15px;
            }
            
            .email-footer {
                padding: 15px;
            }
            
            .info-item strong {
                width: 70px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Selamat Datang!</h2>
        </div>
        
        <div class="email-body">
            <p>Halo <strong>{{ $name }}</strong>,</p>
            <p>Terima kasih telah mendaftar. Registrasi Anda telah berhasil dan akun Anda sudah aktif.</p>
            
            <div class="info-box">
                <div class="info-item">
                    <strong>Email:</strong> {{ $email }}
                </div>
                <div class="info-item">
                    <strong>Password:</strong> {{ $password }}
                </div>
            </div>
            
            <div class="warning-box">
                <b>⚠ PENTING:</b>
                <p>Jangan pernah membagikan informasi akun ini kepada siapa pun, karena akun ini berisi data pribadi Anda. Simpan informasi ini di tempat yang aman.</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="signature">
                <p>Salam,<br><strong>Tim Kami</strong></p>
            </div>
        </div>
    </div>
</body>
</html>