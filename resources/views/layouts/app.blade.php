<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Sepatu</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 1000;
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 2rem;
            width: calc(100% - 260px);
        }
        .nav-link {
            color: #495057;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
        }
        .nav-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }
        .nav-link.active {
            background-color: #0d6efd;
            color: white !important;
            font-weight: 600;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column">
    <div class="p-4 mb-3 border-bottom">
        <a class="text-decoration-none fw-bold fs-4 text-dark d-flex align-items-center" href="{{ route('dashboard') }}">
            <i class="fas fa-shoe-prints text-primary fs-3 me-2"></i> POS Sepatu
        </a>
    </div>
    
    <ul class="nav flex-column px-3 mb-auto">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-home fa-fw me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                <i class="fas fa-shopping-cart fa-fw me-2"></i> Kasir
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('shoes.*') ? 'active' : '' }}" href="{{ route('shoes.index') }}">
                <i class="fas fa-box fa-fw me-2"></i> Data Sepatu
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                <i class="fas fa-tags fa-fw me-2"></i> Kategori
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('promos.*') ? 'active' : '' }}" href="{{ route('promos.index') }}">
                <i class="fas fa-percent fa-fw me-2"></i> Promo
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}" href="{{ route('logs.index') }}">
                <i class="fas fa-history fa-fw me-2"></i> Log Aktivitas
            </a>
        </li>
    </ul>
    
    <div class="p-3 text-center text-muted small mt-auto border-top">
        &copy; {{ date('Y') }} POS Sepatu
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container-fluid p-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
