<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Coffee Shop Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SIMPLE EMBEDDED CSS FOR SIDEBAR & NAVBAR -->
    <style>
        /* Reset */
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        /* ==== SIDEBAR ==== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(135deg, #1a2332 0%, #2d3e50 100%);
            color: white;
            overflow-y: auto;
            z-index: 900;
            transition: transform 0.3s ease;
        }

        /* Sidebar Hidden (collapsed) */
        .sidebar.hide {
            transform: translateX(-260px);
        }

        .sidebar-logo {
            padding: 32px 24px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column; /* Stack vertically */
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4px;
        }

        .sidebar-logo .coffee-icon {
            font-size: 28px;
            color: #fff;
            opacity: 0.9;
        }

        .sidebar-logo h3 {
            font-size: 20px;
            margin: 0;
        }

        .sidebar-logo small {
            font-size: 10px;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 16px 0;
        }

        .menu-item {
            margin: 0;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.2s;
        }

        .menu-link:hover,
        .menu-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .menu-link i {
            width: 20px;
            font-size: 16px;
        }

        /* ==== NAVBAR ==== */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 260px; /* Start after sidebar */
            right: 0;
            height: 70px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            z-index: 1000; /* Above sidebar */
            transition: left 0.3s ease;
        }

        /* Navbar expanded when sidebar hidden */
        .top-navbar.full {
            left: 0;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            color: #333;
        }

        .toggle-btn:hover {
            background: #f0f0f0;
            border-radius: 4px;
        }

        .page-title h2 {
            font-size: 24px;
            color: #333;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .user-role {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #6F4E37;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        /* ==== MAIN CONTENT ==== */
        .main-content {
            margin-left: 260px; /* Space for sidebar */
            margin-top: 70px; /* Space for navbar */
            padding: 32px;
            transition: margin-left 0.3s ease;
        }

        /* Main content expanded when sidebar hidden */
        .main-content.full {
            margin-left: 0;
        }

        /* ==== MOBILE ==== */
        @media (max-width: 768px) {
            .sidebar {
                top: 0; /* Full screen from top */
                height: 100vh; /* Full height */
                transform: translateX(-260px); /* Hidden by default */
                z-index: 1100 !important; /* FORCE above navbar */
            }

            .sidebar.show {
                transform: translateX(0); /* Show on toggle */
            }

            .top-navbar {
                left: 0 !important; /* Always full width */
            }

            .main-content {
                margin-left: 0 !important; /* No sidebar space */
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1050; /* Between navbar (1000) and sidebar (1100) */
            }

            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=5.0.{{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=5.0.{{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}?v=5.0.{{ time() }}">
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-container">
                <i class="fas fa-coffee coffee-icon"></i>
                <h3>Coffee Admin</h3>
            </div>
            <small>SISTEM ADMINISTRASI</small>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('products.index') }}" class="menu-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fas fa-mug-hot"></i>
                    <span>Produk</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('transactions.index') }}" class="menu-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi</span>
                </a>
            </li>

            @if(auth()->user()->role === 'owner')
            <li class="menu-item">
                <a href="{{ route('categories.index') }}" class="menu-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tag"></i>
                    <span>Kategori</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('users.index') }}" class="menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Pegawai</span>
                </a>
            </li>
            @endif

            <li class="menu-item" style="margin-top: 24px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1);">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="menu-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="overlay"></div>

    <!-- Top Navbar -->
    <nav class="top-navbar" id="navbar">
        <div class="navbar-left">
            <button class="toggle-btn" id="toggleBtn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">
                <h2>@yield('page-title', 'Dashboard')</h2>
            </div>
        </div>

        <div class="user-menu">
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role }}</div>
            </div>
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @if(session('success'))
            <div class="alert alert-success">
                <strong>✅</strong>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <strong>⚠️</strong>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- SIMPLE JAVASCRIPT - NO LOCALSTORAGE -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleBtn');
        const overlay = document.getElementById('overlay');

        function isMobile() {
            return window.innerWidth <= 768;
        }

        toggleBtn.addEventListener('click', function() {
            if (isMobile()) {
                // Mobile: toggle sidebar with overlay
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            } else {
                // Desktop: toggle sidebar + adjust navbar & content
                sidebar.classList.toggle('hide');
                navbar.classList.toggle('full');
                mainContent.classList.toggle('full');
            }
        });

        // Close sidebar when clicking overlay (mobile)
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        // Reset on window resize
        window.addEventListener('resize', function() {
            if (!isMobile()) {
                overlay.classList.remove('show');
                sidebar.classList.remove('show');
            } else {
                sidebar.classList.remove('hide');
                navbar.classList.remove('full');
                mainContent.classList.remove('full');
            }
        });
    </script>

    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
