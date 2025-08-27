<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - LPK PT Amarta Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--color-light);
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .navbar-custom {
            background: var(--gradient-primary);
            box-shadow: var(--shadow-soft);
            padding: 1rem 0;
        }

        .navbar-brand {
            background: var(--color-light);
            border-radius: 5px;
            padding: 0.5rem 1rem;
            font-size: 1.25rem; /* dari 1.5rem jadi 1.25rem */
            color: var(--color-primary) !important;
            margin-left: 3.5rem;
        }

        .navbar-nav .nav-link {
            color: white !important;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            transform: translateY(-2px);
        }

        .logo-container {
                background: white;
                border-radius: 10px;
                width: 100px;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                margin-bottom: 30px;
            }

            .logo-container img {
                max-height: 80px;
                width: auto;
            }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: white;
            box-shadow: var(--shadow-soft);
            z-index: 1000;
            transition: all 0.3s ease;
            padding-top: 65px;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.8rem;
            border-bottom: 1px solid #e9ecef;
            background: var(--gradient-light);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 5px 15px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--color-dark);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background: var(--color-hover);
            color: var(--color-primary);
            transform: translateX(5px);
        }

        .sidebar-menu a.active {
            background: var(--gradient-primary);
            color: white;
        }

        .sidebar-menu i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 100px 30px 30px 30px;
            min-height: 100vh;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            border: none;
            margin-bottom: 30px;
        }

        .dashboard-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-5px);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        .stat-label {
            color: var(--color-disabletxt);
            margin: 0;
            font-size: 1rem;
        }

        .stat-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: 0.1;
        }

        /* Color variations for cards */
        .card-primary { --card-color: var(--color-primary); }
        .card-success { --card-color: var(--color-success); }
        .card-warning { --card-color: var(--color-warning); }
        .card-danger { --card-color: var(--color-danger); }
        .card-info { --card-color: var(--color-info); }

        .card-primary::before { background: var(--color-primary); }
        .card-success::before { background: var(--color-success); }
        .card-warning::before { background: var(--color-warning); }
        .card-danger::before { background: var(--color-danger); }
        .card-info::before { background: var(--color-info); }

        .card-primary .stat-number { color: var(--color-primary); }
        .card-success .stat-number { color: var(--color-success); }
        .card-warning .stat-number { color: var(--color-warning); }
        .card-danger .stat-number { color: var(--color-danger); }
        .card-info .stat-number { color: var(--color-info); }

        .card-primary .stat-icon { color: var(--color-primary); }
        .card-success .stat-icon { color: var(--color-success); }
        .card-warning .stat-icon { color: var(--color-warning); }
        .card-danger .stat-icon { color: var(--color-danger); }
        .card-info .stat-icon { color: var(--color-info); }

        /* Welcome Section */
        .welcome-card {
            background: var(--gradient-primary);
            color: white;
            margin-bottom: 30px;
        }

        .welcome-card h1 {
            margin-bottom: 0.5rem;
        }

        /* Custom Buttons */
        .btn-custom-primary {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom-primary:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
            color: white;
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: 15px;
            padding: 1.5rem 2rem;
            margin-bottom: 30px;
            box-shadow: var(--shadow-soft);
        }

        .page-header h1 {
            margin: 0;
            color: var(--color-dark);
            font-size: 1.8rem;
            font-weight: 600;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--color-primary);
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 100px 15px 30px 15px;
            }

            .navbar-toggler {
                display: block !important;
            }
        }

        /* Custom scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--color-primary);
            border-radius: 10px;
        }

        /* Main Content Custom */
        .card-stats {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card-stats:hover {
            transform: translateY(-5px);
        }
        .badge-auto {
            background: linear-gradient(45deg, #28a745, #20c997);
        }
        .badge-manual {
            background: linear-gradient(45deg, #007bff, #6610f2);
        }
        .priority-high {
            border-left: 4px solid #dc3545;
        }
        .priority-medium {
            border-left: 4px solid #ffc107;
        }
        .priority-low {
            border-left: 4px solid #28a745;
        }
        .table th {
        vertical-align: middle;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        font-size: 0.875rem;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Badge styling */
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Dropdown button styling */
        .dropdown-toggle::after {
            display: none;
        }

        /* Card stats styling */
        .card-stats {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Table responsive improvements */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .table td, .table th {
                padding: 0.5rem 0.25rem;
            }
            
            .badge {
                font-size: 0.7rem;
            }
        }

        /* Status badge colors */
        .badge.bg-info {
            background-color: #17a2b8 !important;
        }

        .badge.bg-secondary {
            background-color: #6c757d !important;
        }

        /* Table striped custom colors */
        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(0, 123, 255, 0.02);
        }

        /* Action dropdown */
        .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
            border-radius: 0.375rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.text-danger:hover {
            background-color: #f8d7da;
            color: #721c24 !important;
        }

        /* Title cell styling */
        .table td div strong {
            color: #495057;
            font-size: 0.9rem;
        }

        .table td div small {
            display: block;
            margin-top: 0.25rem;
            line-height: 1.3;
        }

        /* Profile item di sidebar */
        #sidebar {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .sidebar-menu {
            flex: 1; /* Menu mengisi sisa ruang */
        }
        .sidebar-menu .profile-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--color-dark);
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar-menu .profile-item:hover {
            background: var(--color-hover);
            color: var(--color-primary);
        }

        .sidebar-menu .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--color-primary);
            margin-right: 12px;
        }
        .sidebar-menu .profile-name {
            margin-left: 12px;
        }
        #mobileLogoutContainer {
            padding: 15px 20px;
            border-top: 1px solid var(--color-border);
        }
    </style>

@stack('styles')
</head>
<body>

    <!-- Navbar -->
     <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard.users') }}">
                <img src="{{ asset('Asset/img/Amarta-Logo.png') }}" alt="Logo Amarta" style="height: 50px; ">
            </a>
            
            <button class="navbar-toggler d-lg-none" type="button" id="sidebarToggle">
                <i class="fas fa-bars text-white"></i>
            </button>

            <!-- Profile Dropdown -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown" id="profileDropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                             @if(Auth::user()->photo)
                                <img 
                                    src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                    alt="User" 
                                    class="user-avatar me-2"
                                >
                            @else
                                <i class="fas fa-user-circle me-2" style="font-size: 32px; color: white;"></i>
                            @endif
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('users/profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5 class="mb-0"></h5>
        </div>
        <ul class="sidebar-menu" id="sidebarMenu">
            <li id="mobileProfileContainer" class="d-md-none"></li>
            <li>
                <a href="{{ url('dashboard/users') }}" class="{{ request()->routeIs('dashboard.users') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('users/keuangan') }}" class="{{ request()->routeIs('users.keuangan') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>Transaksi
                </a>
            </li>
            <li>
                <a href="{{ url('users/profile') }}" class="{{ request()->routeIs('users.profile.show') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>Profile
                </a>
            </li>
            <div id="mobileLogoutContainer" class="d-md-none"></div>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @hasSection('page-header')
            <div class="page-header">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="mb-3 mb-md-0">
                        <h1>@yield('page-title')</h1>
                        @hasSection('breadcrumb')
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @yield('breadcrumb')
                                </ol>
                            </nav>
                        @endif
                    </div>
                    @hasSection('page-actions')
                        <div>
                            @yield('page-actions')
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript for Mobile Menu -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const profileDropdown = document.getElementById("profileDropdown");
            const mobileProfileContainer = document.getElementById("mobileProfileContainer");
            const mobileLogoutContainer = document.getElementById("mobileLogoutContainer");
            const navbarProfileParent = document.querySelector("#navbarNav .navbar-nav");

            const mobileProfileHTML = `
                <a href="{{ url('users/profile') }}" class="profile-item">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User" class="profile-avatar">
                    @else
                        <i class="fas fa-user-circle me-2" style="font-size: 32px; color: var(--color-primary);"></i>
                    @endif
                    <span class="profile-name">{{ Auth::user()->name }}</span>
                </a>
            `;

            const mobileLogoutHTML = `
                <a href="{{ route('logout') }}" class="profile-item text-danger" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            `;

            function moveProfileDropdown() {
                if (window.innerWidth <= 768) {
                    // Mobile → profile di atas, logout di bawah
                    if (mobileProfileContainer.innerHTML.trim() === "") {
                        mobileProfileContainer.innerHTML = mobileProfileHTML;
                    }
                    if (mobileLogoutContainer.innerHTML.trim() === "") {
                        mobileLogoutContainer.innerHTML = mobileLogoutHTML;
                    }
                    if (navbarProfileParent.contains(profileDropdown)) {
                        navbarProfileParent.removeChild(profileDropdown);
                    }
                } else {
                    // Desktop → balikin ke navbar
                    if (!navbarProfileParent.contains(profileDropdown)) {
                        navbarProfileParent.appendChild(profileDropdown);
                    }
                    mobileProfileContainer.innerHTML = "";
                    mobileLogoutContainer.innerHTML = "";
                }
            }

            moveProfileDropdown();
            window.addEventListener("resize", moveProfileDropdown);
        });

        // Add some interactive effects
        document.querySelectorAll('.dashboard-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Sidebar toggle for mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Main Content Custom Javascript
        document.getElementById('viewModalContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('viewModal')).show();

        // Auto-save draft setiap 30 detik (opsional)
        let autoSaveInterval;

        document.getElementById('announcementModal').addEventListener('shown.bs.modal', function () {
            autoSaveInterval = setInterval(function() {
                const title = document.getElementById('title').value;
                const content = document.getElementById('content').value;
                
                if (title || content) {
                    // Simulasi auto-save
                    console.log('Auto-saving draft...');
                }
            }, 30000);
        });

        document.getElementById('announcementModal').addEventListener('hidden.bs.modal', function () {
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
            }
        });

        // Preview pengumuman saat mengetik
        function previewAnnouncement() {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;
            const type = document.getElementById('type').value;
            
            // Bisa ditambahkan preview real-time di sini
        }

        // Event listeners untuk real-time preview
        document.getElementById('title').addEventListener('input', previewAnnouncement);
        document.getElementById('content').addEventListener('input', previewAnnouncement);


        // Statistics update (simulasi real-time)
        function updateStats() {
            // Simulasi update statistik real-time
            const stats = {
                total: Math.floor(Math.random() * 10) + 5,
                published: Math.floor(Math.random() * 5) + 3,
                draft: Math.floor(Math.random() * 3) + 1,
                totalViews: Math.floor(Math.random() * 100) + 150
            };
            
            // Update DOM jika diperlukan
            // document.querySelector('.card-stats:nth-child(1) h3').textContent = stats.total;
        }

        // Update stats setiap 30 detik
        setInterval(updateStats, 30000);
    </script>

    @stack('scripts')
</body>
</html>