<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UOMS') }} - Lab Manager Panel</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Fix Pagination Arrow Bug & Modern Styles -->
    <style>
        /* ===== FIX PAGINATION ARROW BUG ===== */
        /* Reset pagination completely */
        .pagination {
            display: flex !important;
            list-style: none !important;
            border-radius: 0.25rem !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .pagination .page-link {
            position: relative !important;
            display: block !important;
            padding: 0.5rem 0.75rem !important;
            margin-left: -1px !important;
            line-height: 1.25 !important;
            color: #007bff !important;
            background-color: #fff !important;
            border: 1px solid #dee2e6 !important;
            text-decoration: none !important;
            width: auto !important;
            height: auto !important;
            font-size: 1rem !important;
            transition: all 0.3s ease !important;
            max-width: 50px !important;
            max-height: 40px !important;
        }
        
        /* Hide any SVG or icon content in pagination */
        .pagination .page-link svg,
        .pagination .page-link i,
        .pagination .page-link::before,
        .pagination .page-link::after {
            display: none !important;
        }
        
        /* Force text content only */
        .pagination .page-link {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
        
        .pagination .page-link:hover {
            z-index: 2 !important;
            color: #0056b3 !important;
            background-color: #e9ecef !important;
            border-color: #dee2e6 !important;
        }
        
        .pagination .page-item:first-child .page-link {
            margin-left: 0 !important;
            border-top-left-radius: 0.25rem !important;
            border-bottom-left-radius: 0.25rem !important;
        }
        
        .pagination .page-item:last-child .page-link {
            border-top-right-radius: 0.25rem !important;
            border-bottom-right-radius: 0.25rem !important;
        }
        
        .pagination .page-item.active .page-link {
            z-index: 3 !important;
            color: #fff !important;
            background-color: #007bff !important;
            border-color: #007bff !important;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d !important;
            pointer-events: none !important;
            cursor: not-allowed !important;
            background-color: #fff !important;
            border-color: #dee2e6 !important;
            opacity: 0.5 !important;
        }
        
        /* Hide any rogue FullCalendar or AdminLTE elements */
        .fc-direction-ltr .fc-button-group > *,
        .fc-toolbar .fc-button,
        aside .pagination {
            display: inline-block !important;
            width: auto !important;
            height: auto !important;
        }
        
        /* Specifically hide large pseudo elements */
        nav[role="navigation"] .pagination .page-link::before,
        nav[role="navigation"] .pagination .page-link::after {
            content: none !important;
            display: none !important;
        }
        
        /* ===== MODERN LOGO STYLES ===== */
        .brand-link .brand-image {
            width: 40px !important;
            height: 40px !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            opacity: 1 !important;
        }
        
        .brand-link .brand-image i {
            color: white !important;
            font-size: 20px !important;
        }
    </style>
    
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('user.dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- User Account -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i> {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('user.dashboard') }}" class="brand-link">
            <div class="brand-image elevation-3">
                <i class="fas fa-university"></i>
            </div>
            <span class="brand-text font-weight-light">UOMS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Products -->
                    <li class="nav-item">
                        <a href="{{ route('user.products.index') }}" class="nav-link {{ request()->routeIs('user.products.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Products</p>
                        </a>
                    </li>

                    <!-- Cart -->
                    <li class="nav-item">
                        <a href="{{ route('user.cart.index') }}" class="nav-link {{ request()->routeIs('user.cart.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                My Cart
                                @php
                                    $cartCount = collect(session()->get('cart', []))->sum();
                                @endphp
                                @if($cartCount > 0)
                                    <span class="badge badge-success right">{{ $cartCount }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <!-- Order History -->
                    <li class="nav-item">
                        <a href="{{ route('user.orders.index') }}" class="nav-link {{ request()->routeIs('user.orders.index') || request()->routeIs('user.orders.show') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Order History</p>
                        </a>
                    </li>

                    <!-- Profile -->
                    <li class="nav-item">
                        <a href="{{ route('user.profile.edit') }}" class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="#">UOMS</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>
