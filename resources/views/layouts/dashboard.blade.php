<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
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
            padding-top: 80px;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
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
         /* Welcome Section */
        .welcome-card {
            background: var(--gradient-primary);
            color: white;
            margin-bottom: 30px;
        }

        .welcome-card h1 {
            margin-bottom: 0.5rem;
        }

</style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid ">
            <a class="navbar-brand" href="{{ url('dashboard/user') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                Amarta
            </a>
            
            <button class="navbar-toggler d-lg-none" type="button" id="sidebarToggle">
                <i class="fas fa-bars text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="https://via.placeholder.com/40" alt="User" class="user-avatar me-2">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
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
            <h5 class="mb-0">Navigation</h5>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ url('dashboard/user') }}" class="{{ request()->routeIs('dashboard.user') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('users/transaksi') }}" class="{{ request()->routeIs('users.transaksi') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>Transaksi
                </a>
            </li>
            <li>
                <a href="{{ url('users/profile') }}" class="{{ request()->routeIs('users.profile') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>Profile
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @hasSection('page-header')
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
