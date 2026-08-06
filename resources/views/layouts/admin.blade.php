<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel administrasi resmi SMP Negeri 4 Samarinda">
    <meta name="theme-color" content="#012a63">
    @php
        $currentUser = auth()->user();

        $fullProfile = cache()->remember('layout_admin_profile', 300, function () {
            return \App\Models\SchoolProfile::select([
                'nama_sekolah',
                'logo_path',
            ])->first();
        });

        $logoPath = optional($fullProfile)->logo_path;
        $uploadedLogoUrl = $logoPath
            ? asset('storage/' . ltrim($logoPath, '/'))
            : asset('img/logo-smp4.jpg');

        $cachedFaviconPath = cache()->remember('school_profile_favicon', 60, function () {
            return \Illuminate\Support\Facades\Storage::disk('public')->exists('branding/favicon.ico')
                ? 'branding/favicon.ico'
                : null;
        });

        $adminFaviconUrl = $cachedFaviconPath
            ? asset('storage/' . $cachedFaviconPath)
            : $uploadedLogoUrl;

        $adminBrandName = optional($fullProfile)->nama_sekolah ?? 'SMPN 4 Admin';
        $shortBrandName = $adminBrandName
            ? trim(collect(explode(' ', $adminBrandName))->take(3)->join(' '))
            : 'SMP Negeri 4';

        $menuItems = [
            ['label' => 'Dashboard', 'icon' => 'fas fa-gauge', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'permission' => 'dashboard.view'],
            ['label' => 'Profil Sekolah', 'icon' => 'fas fa-school', 'route' => 'admin.profile.edit', 'pattern' => 'admin.profile.*', 'permission' => 'profile.update'],
            ['label' => 'Kepala Sekolah', 'icon' => 'fas fa-user-tie', 'route' => 'admin.former-principals.index', 'pattern' => 'admin.former-principals.*', 'permission' => 'profile.update'],
            ['label' => 'Slider Beranda', 'icon' => 'fas fa-images', 'route' => 'admin.home-sliders.index', 'pattern' => 'admin.home-sliders.*', 'permission' => 'sliders.manage'],
            ['label' => 'Berita', 'icon' => 'fas fa-newspaper', 'route' => 'admin.posts.index', 'pattern' => 'admin.posts.*', 'permission' => ['posts.manage', 'posts.academic', 'posts.sarpras']],
            ['label' => 'GTK', 'icon' => 'fas fa-user-graduate', 'route' => 'admin.teachers.index', 'pattern' => 'admin.teachers.*', 'permission' => 'teachers.manage'],
            ['label' => 'Fasilitas', 'icon' => 'fas fa-building', 'route' => 'admin.facilities.index', 'pattern' => 'admin.facilities.*', 'permission' => 'facilities.manage'],
            ['label' => 'Portal Aplikasi', 'icon' => 'fas fa-sitemap', 'route' => 'admin.application-links.index', 'pattern' => 'admin.application-links.*', 'permission' => 'application-links.manage'],
            ['label' => 'Halaman Akademik', 'icon' => 'fas fa-graduation-cap', 'route' => 'admin.academic.edit', 'pattern' => 'admin.academic.*', 'permission' => 'academic.manage'],
            ['label' => 'PPDB', 'icon' => 'fas fa-address-card', 'route' => 'admin.ppdb.index', 'pattern' => 'admin.ppdb.*', 'permission' => 'ppdb.manage'],
            ['label' => 'Galeri', 'icon' => 'fas fa-images', 'route' => 'admin.galleries.index', 'pattern' => 'admin.galleries.*', 'permission' => 'galleries.manage'],
            ['label' => 'Galeri Video', 'icon' => 'fas fa-video', 'route' => 'admin.gallery-videos.index', 'pattern' => 'admin.gallery-videos.*', 'permission' => 'gallery-videos.manage'],
            ['label' => 'Pesan', 'icon' => 'fas fa-inbox', 'route' => 'admin.messages.index', 'pattern' => 'admin.messages.*', 'permission' => 'messages.view'],
            ['label' => 'Pengguna', 'icon' => 'fas fa-users-cog', 'route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'permission' => 'users.manage'],
            ['label' => 'Log Aktivitas', 'icon' => 'fas fa-clipboard-list', 'route' => 'admin.logs.index', 'pattern' => 'admin.logs.index', 'permission' => 'activity.logs.view'],
        ];
    @endphp

    <link rel="icon" href="{{ $adminFaviconUrl }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $adminFaviconUrl }}" type="image/x-icon">

    <title>@yield('title', 'Panel Admin') - SMPN 4 Samarinda</title>

    <!-- AdminLTE & Dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars/css/OverlayScrollbars.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ============================================
           ADMIN DESIGN SYSTEM — PROFESSIONAL THEME
           ============================================ */
        :root {
            --adm-sidebar-bg:    #0f172a;
            --adm-sidebar-hover: #1e293b;
            --adm-sidebar-text:  rgba(148, 163, 184, 1);
            --adm-sidebar-head:  rgba(71, 85, 105, 0.8);
            --adm-accent:        #2563eb;
            --adm-accent-light:  #eff6ff;
            --adm-accent-dark:   #1d4ed8;
            --adm-warning:       #f59e0b;
            --adm-success:       #10b981;
            --adm-danger:        #ef4444;
            --adm-info:          #06b6d4;
            --adm-bg:            #f1f5f9;
            --adm-surface:       #ffffff;
            --adm-border:        #e2e8f0;
            --adm-text:          #0f172a;
            --adm-muted:         #64748b;
            --adm-radius:        12px;
            --adm-radius-sm:     8px;
            --adm-shadow:        0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
            --adm-shadow-md:     0 4px 16px rgba(0,0,0,.08);
            --adm-shadow-lg:     0 10px 30px rgba(0,0,0,.10);
        }

        /* Base */
        body, html { font-family: 'Inter', system-ui, sans-serif !important; }
        body { background: var(--adm-bg) !important; color: var(--adm-text) !important; }

        /* ── TOPBAR ── */
        .main-header {
            background: var(--adm-surface) !important;
            border-bottom: 1px solid var(--adm-border) !important;
            box-shadow: var(--adm-shadow) !important;
            height: 64px;
        }
        .main-header .nav-link,
        .main-header .navbar-nav .nav-link {
            color: var(--adm-muted) !important;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.5rem 0.85rem !important;
            border-radius: var(--adm-radius-sm);
            transition: all 0.2s;
        }
        .main-header .nav-link:hover,
        .main-header .navbar-nav .nav-link:hover {
            color: var(--adm-accent) !important;
            background: var(--adm-accent-light) !important;
        }
        .main-header .navbar-nav .nav-link i { font-size: 0.9rem; }
        /* Topbar pushmenu icon */
        .main-header [data-widget="pushmenu"] { color: var(--adm-muted) !important; }

        /* Topbar user dropdown */
        .main-header .user-image { border: 2px solid var(--adm-accent) !important; border-radius: 10px !important; }
        .main-header .user-menu > .nav-link span { color: var(--adm-text) !important; font-weight: 500; font-size: 0.875rem; }

        /* ── SIDEBAR ── */
        .main-sidebar {
            background: var(--adm-sidebar-bg) !important;
            box-shadow: 2px 0 20px rgba(0,0,0,0.25) !important;
        }

        .brand-link {
            background: #080f1e !important;
            border-bottom: 1px solid rgba(255,255,255,0.06) !important;
            padding: 0 1.25rem !important;
            min-height: 64px !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
        }
        .brand-link .brand-image {
            width: 38px !important;
            height: 38px !important;
            object-fit: contain !important;
            background: #fff !important;
            border-radius: 10px !important;
            padding: 4px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
            margin: 0 !important;
        }
        .brand-link .brand-text {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            color: #fff !important;
            letter-spacing: -0.01em !important;
        }

        /* Sidebar scrollable area */
        .sidebar { padding: 0 0.75rem 2rem !important; background: transparent !important; }

        /* User card */
        .sidebar-user-card {
            margin: 1rem 0 !important;
            padding: 0.85rem 1rem !important;
            background: rgba(255,255,255,0.04) !important;
            border-radius: var(--adm-radius) !important;
            border: 1px solid rgba(255,255,255,0.06) !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
        }
        .sidebar-user-card .image img {
            width: 42px !important; height: 42px !important;
            border-radius: 12px !important;
            border: 2px solid rgba(37,99,235,0.5) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
        }
        .sidebar-user-card .info a {
            color: #f1f5f9 !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
        }
        .sidebar-user-card .info span {
            color: var(--adm-sidebar-text) !important;
            font-size: 0.75rem !important;
        }

        /* Nav items container */
        .sidebar-menu-card {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Nav section header */
        .nav-header-label {
            font-size: 0.65rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            color: var(--adm-sidebar-head) !important;
            padding: 1.25rem 0.75rem 0.5rem !important;
            margin: 0 !important;
            display: block !important;
        }

        /* Nav links */
        .nav-sidebar .nav-item { margin: 0 0 2px !important; }
        .nav-sidebar .nav-link {
            border-radius: var(--adm-radius-sm) !important;
            padding: 0.6rem 0.85rem !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            color: var(--adm-sidebar-text) !important;
            transition: all 0.18s ease !important;
            position: relative !important;
            white-space: nowrap !important;
        }
        .nav-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.07) !important;
            color: #f1f5f9 !important;
        }
        .nav-sidebar .nav-link .nav-icon {
            width: 32px !important;
            height: 32px !important;
            border-radius: var(--adm-radius-sm) !important;
            background: rgba(255,255,255,0.07) !important;
            color: var(--adm-sidebar-text) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 0.85rem !important;
            flex-shrink: 0 !important;
            transition: all 0.18s ease !important;
        }
        .nav-sidebar .nav-link:hover .nav-icon {
            background: rgba(37,99,235,0.2) !important;
            color: #93c5fd !important;
        }
        .nav-sidebar .nav-link.active {
            background: var(--adm-accent) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(37,99,235,0.4) !important;
        }
        .nav-sidebar .nav-link.active .nav-icon {
            background: rgba(255,255,255,0.2) !important;
            color: #ffffff !important;
        }
        .nav-sidebar .nav-link p {
            margin: 0 !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            flex: 1 !important;
        }

        /* Sidebar collapse tweaks */
        .sidebar-inner {
            display: flex !important;
            flex-direction: column !important;
            min-height: calc(100vh - 64px) !important;
        }
        .sidebar-mini.sidebar-collapse .brand-link { justify-content: center !important; }
        .sidebar-mini.sidebar-collapse.sidebar-open .brand-link,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .brand-link { justify-content: flex-start !important; }
        .sidebar-mini.sidebar-collapse .brand-link .brand-text,
        .sidebar-mini.sidebar-collapse .nav-header-label,
        .sidebar-mini.sidebar-collapse .sidebar-user-card { display: none !important; }
        .sidebar-mini.sidebar-collapse.sidebar-open .brand-link .brand-text,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .brand-link .brand-text { display: inline-block !important; }
        .sidebar-mini.sidebar-collapse.sidebar-open .nav-header-label,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .nav-header-label,
        .sidebar-mini.sidebar-collapse.sidebar-open .sidebar-user-card,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .sidebar-user-card { display: flex !important; }
        .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link { justify-content: center !important; padding: 0.65rem 0.3rem !important; }
        .sidebar-mini.sidebar-collapse.sidebar-open .nav-sidebar .nav-link,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .nav-sidebar .nav-link { justify-content: flex-start !important; padding: 0.6rem 0.85rem !important; }
        .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link p { display: none !important; }
        .sidebar-mini.sidebar-collapse.sidebar-open .nav-sidebar .nav-link p,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .nav-sidebar .nav-link p { display: block !important; }

        /* ── CONTENT WRAPPER ── */
        .content-wrapper {
            background: var(--adm-bg) !important;
            min-height: calc(100vh - 64px) !important;
        }

        /* Page header */
        .content-header {
            padding: 1.5rem 1.5rem 0 !important;
            background: transparent !important;
        }
        .content-header h1 {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 1.4rem !important;
            font-weight: 700 !important;
            color: var(--adm-text) !important;
            margin: 0 !important;
        }
        .content-header .breadcrumb {
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 0.8rem !important;
        }
        .content-header .breadcrumb-item a { color: var(--adm-accent) !important; text-decoration: none !important; }
        .content-header .breadcrumb-item.active { color: var(--adm-muted) !important; }

        /* Content section */
        .content { padding: 1.25rem 1.5rem 2rem !important; }

        /* ── CARDS ── */
        .card {
            border: 1px solid var(--adm-border) !important;
            border-radius: var(--adm-radius) !important;
            box-shadow: var(--adm-shadow) !important;
            background: var(--adm-surface) !important;
            transition: box-shadow 0.2s ease !important;
        }
        .card:hover { box-shadow: var(--adm-shadow-md) !important; }
        .card-header {
            background: var(--adm-surface) !important;
            border-bottom: 1px solid var(--adm-border) !important;
            padding: 1rem 1.25rem !important;
            border-radius: var(--adm-radius) var(--adm-radius) 0 0 !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            color: var(--adm-text) !important;
        }
        .card-body { padding: 1.25rem !important; }
        .card-footer {
            background: #f8fafc !important;
            border-top: 1px solid var(--adm-border) !important;
            border-radius: 0 0 var(--adm-radius) var(--adm-radius) !important;
            padding: 0.85rem 1.25rem !important;
        }

        /* ── TABLES ── */
        .table { font-size: 0.875rem !important; }
        .table thead th {
            background: #f8fafc !important;
            border-bottom: 2px solid var(--adm-border) !important;
            color: var(--adm-muted) !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 0.85rem 1rem !important;
        }
        .table td {
            vertical-align: middle !important;
            padding: 0.85rem 1rem !important;
            border-color: var(--adm-border) !important;
            color: var(--adm-text) !important;
        }
        .table tbody tr:hover { background: #f8fafc !important; }
        .table-responsive { border-radius: var(--adm-radius) !important; }

        /* ── FORMS ── */
        .form-control, .form-select {
            border: 1px solid var(--adm-border) !important;
            border-radius: var(--adm-radius-sm) !important;
            font-size: 0.875rem !important;
            color: var(--adm-text) !important;
            background: var(--adm-surface) !important;
            padding: 0.55rem 0.85rem !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--adm-accent) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12) !important;
            outline: none !important;
        }
        .form-label {
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            color: var(--adm-muted) !important;
            text-transform: uppercase !important;
            letter-spacing: 0.04em !important;
            margin-bottom: 0.4rem !important;
        }
        .input-group-text {
            border: 1px solid var(--adm-border) !important;
            background: #f8fafc !important;
            color: var(--adm-muted) !important;
            border-radius: var(--adm-radius-sm) !important;
        }

        /* ── BUTTONS ── */
        .btn {
            border-radius: var(--adm-radius-sm) !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
            padding: 0.5rem 1.1rem !important;
            transition: all 0.2s !important;
        }
        .btn-primary, .btn-primary-custom {
            background: var(--adm-accent) !important;
            border-color: var(--adm-accent) !important;
            color: #fff !important;
            box-shadow: 0 2px 8px rgba(37,99,235,0.25) !important;
        }
        .btn-primary:hover, .btn-primary-custom:hover {
            background: var(--adm-accent-dark) !important;
            border-color: var(--adm-accent-dark) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 14px rgba(37,99,235,0.35) !important;
        }
        .btn-danger { background: var(--adm-danger) !important; border-color: var(--adm-danger) !important; color: #fff !important; }
        .btn-success { background: var(--adm-success) !important; border-color: var(--adm-success) !important; color: #fff !important; }
        .btn-warning { background: var(--adm-warning) !important; border-color: var(--adm-warning) !important; color: #fff !important; }
        .btn-outline-primary { border-color: var(--adm-accent) !important; color: var(--adm-accent) !important; }
        .btn-outline-primary:hover { background: var(--adm-accent) !important; color: #fff !important; }
        .btn-sm { padding: 0.35rem 0.75rem !important; font-size: 0.8rem !important; }

        /* ── BADGES ── */
        .badge {
            font-size: 0.72rem !important;
            font-weight: 600 !important;
            padding: 0.3em 0.65em !important;
            border-radius: 6px !important;
        }
        .badge.bg-primary, .badge-primary { background: var(--adm-accent) !important; }
        .badge.bg-success, .badge-success { background: var(--adm-success) !important; }
        .badge.bg-danger, .badge-danger { background: var(--adm-danger) !important; }
        .badge.bg-warning, .badge-warning { background: var(--adm-warning) !important; color: #fff !important; }
        .badge.bg-info, .badge-info { background: var(--adm-info) !important; }
        .badge-light { background: var(--adm-border) !important; color: var(--adm-text) !important; }

        /* ── ALERTS ── */
        .alert { border-radius: var(--adm-radius) !important; border: none !important; font-size: 0.875rem !important; }
        .alert-success { background: #d1fae5 !important; color: #065f46 !important; }
        .alert-danger { background: #fee2e2 !important; color: #991b1b !important; }
        .alert-warning { background: #fef3c7 !important; color: #92400e !important; }
        .alert-info { background: #cffafe !important; color: #155e75 !important; }

        /* ── FOOTER ── */
        .main-footer {
            background: var(--adm-surface) !important;
            border-top: 1px solid var(--adm-border) !important;
            color: var(--adm-muted) !important;
            font-size: 0.8rem !important;
            padding: 0.85rem 1.5rem !important;
        }

        /* ── PAGINATION ── */
        .pagination .page-link {
            border-radius: var(--adm-radius-sm) !important;
            margin: 0 2px !important;
            color: var(--adm-accent) !important;
            border-color: var(--adm-border) !important;
            font-size: 0.8rem !important;
        }
        .pagination .page-item.active .page-link {
            background: var(--adm-accent) !important;
            border-color: var(--adm-accent) !important;
            color: #fff !important;
        }

        /* ── DROPDOWN ── */
        .dropdown-menu {
            border: 1px solid var(--adm-border) !important;
            border-radius: var(--adm-radius) !important;
            box-shadow: var(--adm-shadow-lg) !important;
            font-size: 0.875rem !important;
        }
        .dropdown-item { padding: 0.55rem 1.1rem !important; color: var(--adm-text) !important; font-size: 0.875rem !important; }
        .dropdown-item:hover { background: var(--adm-accent-light) !important; color: var(--adm-accent) !important; }

        /* ── TOPBAR BADGE ── */
        .badge-notif {
            background: var(--adm-accent) !important;
            color: #fff !important;
            font-size: 0.65rem !important;
            border-radius: 6px !important;
        }

        /* ── LIST GROUP ── */
        .list-group-item { border-color: var(--adm-border) !important; font-size: 0.875rem !important; }
        .list-group-item.active { background: var(--adm-accent) !important; border-color: var(--adm-accent) !important; }

        /* ── MISC ── */
        .text-primary { color: var(--adm-accent) !important; }
        .bg-primary { background: var(--adm-accent) !important; }
        hr { border-color: var(--adm-border) !important; opacity: 1 !important; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed @yield('body-classes')">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-md-inline-block">
                <span class="nav-link text-uppercase small fw-bold text-white-50">Panel Admin SMPN 4</span>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-globe-asia me-2"></i>Lihat Situs</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.messages.index') }}" class="nav-link">
                    <i class="fas fa-paper-plane me-2"></i>Pesan Masuk
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-pill badge-notif ml-1">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">Tidak ada notifikasi baru</span>
                </div>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email ?? 'admin@smpn4.test'))) }}?s=160&d=identicon" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Administrator' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li class="user-header bg-primary">
                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email ?? 'admin@smpn4.test'))) }}?s=160&d=identicon" class="img-circle elevation-2" alt="User Image">
                        <p>
                            {{ auth()->user()->name ?? 'Administrator' }}
                            <small>Login sebagai Admin</small>
                        </p>
                    </li>
                    <li class="user-footer d-flex justify-content-between">
                        <a href="{{ route('home') }}" class="btn btn-default btn-flat">Beranda</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-flat">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center gap-2">
            <img src="{{ $uploadedLogoUrl }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.9" onerror="this.style.display='none'">
            <span class="brand-text font-weight-semibold">{{ $shortBrandName }}</span>
        </a>
        <div class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-user-card mt-3">
                    <div class="image">
                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email ?? 'admin@smpn4.test'))) }}?s=160&d=identicon" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block mb-1">{{ auth()->user()->name ?? 'Administrator' }}</a>
                        <span class="text-muted small d-block">Administrator</span>
                    </div>
                </div>

                <nav class="sidebar-menu-card">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header-label">Menu Utama</li>
                        @foreach($menuItems as $item)
                            @php
                                $permissions = (array) ($item['permission'] ?? []);
                                $visible = empty($permissions) || ($currentUser && collect($permissions)->contains(fn ($perm) => $currentUser->hasPermission($perm)));
                            @endphp
                            @if(! $visible)
                                @continue
                            @endif
                            @php $active = request()->routeIs($item['pattern']); @endphp
                            <li class="nav-item">
                                <a href="{{ route($item['route']) }}" class="nav-link {{ $active ? 'active' : '' }}">
                                    <i class="nav-icon {{ $item['icon'] }}"></i>
                                    <p>{{ $item['label'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Panel Admin')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumbs')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>&copy; {{ date('Y') }} SMP Negeri 4 Samarinda.</strong>
        <span class="float-right d-none d-sm-inline">Developed by arifwbo</span>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    const initWysiwygEditors = () => {
        if (typeof ClassicEditor === 'undefined') {
            return;
        }

        document.querySelectorAll('textarea.wysiwyg-editor').forEach((textarea) => {
            if (textarea.dataset.editorInitialized === 'true') {
                return;
            }

            ClassicEditor
                .create(textarea, {
                    toolbar: {
                        items: [
                            'undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'underline', 'link', '|',
                            'bulletedList', 'numberedList', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'horizontalLine', '|', 'removeFormat'
                        ]
                    },
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' },
                            { model: 'heading2', view: 'h2', title: 'Judul 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Judul 3', class: 'ck-heading_heading3' }
                        ]
                    },
                    link: {
                        defaultProtocol: 'https://'
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    },
                    placeholder: textarea.getAttribute('placeholder') || 'Ketik konten di sini...'
                })
                .then((editor) => {
                    textarea.dataset.editorInitialized = 'true';

                    textarea.closest('form')?.addEventListener('submit', () => {
                        textarea.value = editor.getData();
                    });
                })
                .catch((error) => {
                    console.error('CKEditor init error', error);
                });
        });
    };

    const initSidebarBehavior = () => {
        document.body.classList.remove('sidebar-collapse');

        const ensureExpanded = () => {
            if (window.innerWidth >= 992) {
                document.body.classList.remove('sidebar-collapse');
            }
        };

        window.addEventListener('resize', ensureExpanded);

        if (window.jQuery && typeof window.jQuery.fn.PushMenu === 'function') {
            window.jQuery('[data-widget="pushmenu"]').PushMenu({
                autoCollapseSize: false,
                enableRemember: false,
                expandOnHover: true,
                expandTransitionDelay: 150
            });
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        initWysiwygEditors();
        initSidebarBehavior();
    });
</script>
@stack('scripts')
</body>
</html>
