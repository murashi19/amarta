<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Undangan Meeting LPK Amarta Bangun Indonesia Cabang Cibitung</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            padding: 2rem 1rem;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .invitation-card {
            background: #0d5ea6;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .header-section {
            padding: 3rem 2rem 2rem;
            text-align: center;
            color: white;
        }
        
        .company-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: #667eea;
            font-weight: bold;
        }
        
        .header-section h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .header-section p {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .card-body {
            background: white;
            padding: 2.5rem 2rem;
        }
        
        .meeting-title {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .meeting-title h2 {
            color: #007bff;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        
        .alert-info {
            background: #e7f3ff;
            border: 1px solid #b3d7ff;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            color: #0c5aa6;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-icon {
            font-size: 1.2rem;
            color: #007bff;
        }
        
        .meeting-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #007bff;
            margin-bottom: 1rem;
        }
        
        .info-item .icon {
            font-size: 1.5rem;
            color: #007bff;
            min-width: 24px;
        }
        
        .info-content strong {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            color: #333;
        }
        
        .info-content span {
            font-size: 1rem;
            color: #666;
        }
        
        .meet-link-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
            border-left: 4px solid #007bff;
        }
        
        .meet-link-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .meet-link-header .icon {
            font-size: 1.5rem;
            color: #007bff;
        }
        
        .meet-link-header strong {
            font-size: 1.1rem;
            color: #333;
        }
        
        .meet-button {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            margin-bottom: 1rem;
            transition: background 0.3s ease;
        }
        
        .meet-button:hover {
            background: #0056b3;
        }
        
        .meet-url {
            font-size: 0.9rem;
            color: #666;
            word-break: break-all;
            background: white;
            padding: 0.8rem;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        
        .alert-warning {
            background: #fff8e1;
            border: 1px solid #ffcc02;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
        }
        
        .alert-warning .icon {
            font-size: 1.3rem;
            color: #ff8f00;
            min-width: 20px;
        }
        
        .alert-warning .content strong {
            color: #e65100;
        }
        
        .action-buttons {
            text-align: center;
            margin: 2rem 0;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            display: inline-block;
            transition: background 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: #0056b3;
        }
        
        .footer-info {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .footer-info .icon {
            color: #28a745;
        }
        
        /* Icons using CSS */
        .icon-building::before { content: "🏢"; }
        .icon-info::before { content: "ℹ️"; }
        .icon-calendar::before { content: "📅"; }
        .icon-clock::before { content: "🕐"; }
        .icon-video::before { content: "📹"; }
        .icon-warning::before { content: "⚠️"; }
        .icon-shield::before { content: "🛡️"; }
        .icon-external::before { content: "🔗"; }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 1rem 0.5rem;
            }
            
            .header-section {
                padding: 2rem 1rem;
            }
            
            .card-body {
                padding: 1.5rem 1rem;
            }
            
            .meeting-details {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .info-item {
                padding: 1rem;
            }
            
            .header-section h1 {
                font-size: 1.5rem;
            }
            
            .meeting-title h2 {
                font-size: 1.4rem;
            }
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .invitation-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
            
            .meet-button, .btn-primary {
                background: white !important;
                color: #007bff !important;
                border: 1px solid #007bff;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="invitation-card">
            <!-- Header Section -->
            <div class="header-section">
                <h1>LPK Amarta Bangun Indonesia</h1>
                <p>Undangan Rapat Virtual</p>
            </div>
            
            <!-- Content Section -->
            <div class="card-body">
                <div class="meeting-title">
                    <h2>{{ $title }}</h2>
                    <div class="alert-info">
                        <span class="icon-info info-icon"></span>
                        <span>{{ $content }}</span>
                    </div>
                </div>
                
                <!-- Meeting Details -->
                <div class="meeting-details">
                    <div class="info-item">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="calendar" style="width:24px; height:24px; vertical-align:top; margin-right:10px;">
                        <div class="info-content">
                            <strong>Tanggal</strong>
                            <span>{{ \Carbon\Carbon::parse($scheduledAt)->locale('id')->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <img src="https://cdn-icons-png.flaticon.com/512/1827/1827301.png" alt="video" style="width:30px; vertical-align:middle; margin-right:8px;">
                        <div class="info-content">
                            <strong>Waktu</strong>
                            <span>{{ \Carbon\Carbon::parse($scheduledAt)->format('H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
                
                <!-- Link Meeting -->
                <div class="meet-link-section">
                    <div class="meet-link-header">
                        <strong>Link Meeting</strong>
                    </div>
                    <a href="{{ $meetLink }}" class="meet-button text-white" target="_blank">
                        <img src="https://cdn-icons-png.flaticon.com/512/25/25284.png" alt="video" style="width:24px;  vertical-align:middle; margin-right:8px;"> Bergabung ke Meeting
                    </a>
                    <div class="meet-url">{{ $meetLink }}</div>
                </div>
                
                <!-- Footer Message -->
                <div class="alert-warning">
                    <img src="	https://cdn-icons-png.flaticon.com/512/463/463612.png" alt="video" style="width:24px; vertical-align:middle; margin-right:8px;">
                    <div class="content">
                        <strong>Penting:</strong> Harap hadir tepat waktu. Terima kasih atas partisipasi Anda.
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ $meetLink }}" class="btn-primary" target="_blank">
                        Bergabung Sekarang
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Additional Info -->
        <div class="footer-info">
            <span class="icon-shield icon"></span>
            Undangan ini dibuat secara otomatis oleh sistem LPK Amarta Bangun Indonesia
        </div>
    </div>
</body>
</html>