<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @php
        $fullProfile = cache()->remember('school_profile_full', 60, function () {
            return \App\Models\SchoolProfile::select('nama_sekolah', 'logo_path')->first();
        });

        $logoPath = optional($fullProfile)->logo_path;
        $uploadedLogoUrl = $logoPath ? asset('storage/' . $logoPath) : asset('img/logo-smp4.jpg');

        $cachedFaviconPath = cache()->get('school_profile_favicon');
        if (! $cachedFaviconPath && \Illuminate\Support\Facades\Storage::disk('public')->exists('branding/favicon.ico')) {
            $cachedFaviconPath = 'branding/favicon.ico';
        }

        $adminFaviconUrl = $cachedFaviconPath
            ? asset('storage/' . $cachedFaviconPath)
            : $uploadedLogoUrl;

        $adminBrandName = optional($fullProfile)->nama_sekolah ?? 'SMPN 4 Admin';
        $shortBrandName = $adminBrandName
            ? trim(collect(explode(' ', $adminBrandName))->take(3)->join(' '))
            : 'SMP Negeri 4';
    @endphp

    <link rel="icon" href="{{ $adminFaviconUrl }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $adminFaviconUrl }}" type="image/x-icon">

    <title>@yield('title', 'Panel Admin') - SMPN 4 Samarinda</title>

    <!-- AdminLTE & Dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars/css/OverlayScrollbars.min.css">

    <style>
        :root {
            --admin-brand: #012a63;
            --admin-brand-dark: #00163a;
            --admin-accent: #fbbf24;
            --admin-accent-dark: #f59e0b;
        }

        .main-header {
            background: linear-gradient(90deg, var(--admin-brand), var(--admin-brand-dark));
            border-bottom: none;
        }

        .main-header .nav-link,
        .main-header .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
        }

        .main-header .nav-link:hover,
        .main-header .navbar-nav .nav-link:focus {
            color: #fff;
        }

        .main-sidebar {
            background: linear-gradient(180deg, var(--admin-brand-dark), var(--admin-brand));
        }

        .brand-link {
            background: rgba(255, 255, 255, 0.04);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            gap: 0.75rem;
            min-height: 70px;
        }

        .brand-link .brand-text {
            letter-spacing: 0.08em;
        }

        .brand-link .brand-image {
            width: 44px;
            height: 44px;
            object-fit: contain;
            background: #fff;
            padding: 0.25rem;
        }

        .nav-sidebar .nav-link {
            border-radius: 0.65rem;
            margin: 0 0.35rem 0.35rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            padding: 0.65rem 0.85rem;
            position: relative;
        }

        .nav-sidebar .nav-link.active {
            background: linear-gradient(90deg, var(--admin-accent), var(--admin-accent-dark));
            color: #1f2937;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .nav-sidebar .nav-link.active .nav-icon {
            color: var(--admin-brand);
        }

        .nav-sidebar .nav-link .nav-icon {
            color: rgba(255, 255, 255, 0.8);
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            font-size: 0.95rem;
        }

        .nav-sidebar .nav-item + .nav-item {
            margin-top: 0.2rem;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-sidebar .nav-link.active::before {
            content: '';
            width: 6px;
            height: 24px;
            border-radius: 999px;
            background: var(--admin-accent-dark);
            position: absolute;
            left: -10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .nav-sidebar .nav-link.active .nav-icon,
        .nav-sidebar .nav-link:hover .nav-icon {
            background: rgba(255, 255, 255, 0.92);
        }

        .nav-header-label {
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 1.25rem 1rem 0.5rem;
            color: rgba(255, 255, 255, 0.45);
        }

        .sidebar {
            padding: 0 1rem 2rem;
        }

        .sidebar-inner {
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 70px);
        }

        .sidebar-user-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .sidebar-user-card .image img {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.3);
        }

        .sidebar-user-card .info a {
            font-weight: 600;
        }

        .sidebar-menu-card {
            margin-top: 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1.25rem 0.75rem 1.5rem;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.02);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu-card .nav {
            flex: 1;
        }

        .sidebar-mini.sidebar-collapse .brand-link {
            justify-content: center;
        }

        .sidebar-mini.sidebar-collapse.sidebar-open .brand-link,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .brand-link {
            justify-content: flex-start;
        }

        .sidebar-mini.sidebar-collapse .brand-link .brand-text,
        .sidebar-mini.sidebar-collapse .nav-header-label,
        .sidebar-mini.sidebar-collapse .sidebar-user-card {
            display: none !important;
        }

        .sidebar-mini.sidebar-collapse.sidebar-open .brand-link .brand-text,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .brand-link .brand-text {
            display: inline-block !important;
        }

        .sidebar-mini.sidebar-collapse.sidebar-open .nav-header-label,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .nav-header-label,
        .sidebar-mini.sidebar-collapse.sidebar-open .sidebar-user-card,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .sidebar-user-card {
            display: block !important;
        }

        .sidebar-mini.sidebar-collapse.sidebar-open .sidebar-user-card,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .sidebar-user-card {
            display: flex !important;
        }

        .sidebar-mini.sidebar-collapse .sidebar {
            padding: 0.75rem 0.45rem 1rem;
        }

        .sidebar-mini.sidebar-collapse.sidebar-open .sidebar,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .sidebar {
            padding: 0 1rem 2rem;
        }

        .sidebar-mini.sidebar-collapse .sidebar-menu-card {
            padding: 0.5rem 0.3rem 1rem;
            border-radius: 1rem;
        }

        .sidebar-mini.sidebar-collapse.sidebar-open .sidebar-menu-card,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .sidebar-menu-card {
            padding: 1.25rem 0.75rem 1.5rem;
        }

        .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link {
            justify-content: center;
            margin: 0.25rem 0.15rem;
            padding: 0.65rem 0.25rem;
        }

        .sidebar-mini.sidebar-collapse.sidebar-open .nav-sidebar .nav-link,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .nav-sidebar .nav-link {
            justify-content: flex-start;
            margin: 0 0.35rem 0.35rem;
            padding: 0.65rem 0.85rem;
        }

        .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link p,
        .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link::before {
            display: none !important;
        }

        .sidebar-mini.sidebar-collapse.sidebar-open .nav-sidebar .nav-link p,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .nav-sidebar .nav-link::before,
        .sidebar-mini.sidebar-collapse.sidebar-is-opening .nav-sidebar .nav-link p,
        .sidebar-mini.sidebar-collapse.sidebar-open .nav-sidebar .nav-link::before {
            display: block !important;
        }

        .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link .nav-icon {
            margin: 0;
        }

        .main-header .badge-notif {
            background: var(--admin-accent);
            color: #1f2937;
            font-weight: 600;
        }

        /* Gunakan gaya collapse bawaan AdminLTE */
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

                @php
                $menuItems = [
                    ['label' => 'Dashboard', 'icon' => 'fas fa-gauge', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard'],
                    ['label' => 'Profil Sekolah', 'icon' => 'fas fa-school', 'route' => 'admin.profile.edit', 'pattern' => 'admin.profile.*'],
                    ['label' => 'Kepala Sekolah', 'icon' => 'fas fa-user-tie', 'route' => 'admin.former-principals.index', 'pattern' => 'admin.former-principals.*'],
                    ['label' => 'Slider Beranda', 'icon' => 'fas fa-images', 'route' => 'admin.home-sliders.index', 'pattern' => 'admin.home-sliders.*'],
                    ['label' => 'Berita', 'icon' => 'fas fa-newspaper', 'route' => 'admin.posts.index', 'pattern' => 'admin.posts.*'],
                    ['label' => 'GTK', 'icon' => 'fas fa-user-graduate', 'route' => 'admin.teachers.index', 'pattern' => 'admin.teachers.*'],
                    ['label' => 'Fasilitas', 'icon' => 'fas fa-building', 'route' => 'admin.facilities.index', 'pattern' => 'admin.facilities.*'],
                    ['label' => 'Halaman Akademik', 'icon' => 'fas fa-graduation-cap', 'route' => 'admin.academic.edit', 'pattern' => 'admin.academic.*'],
                    ['label' => 'PPDB', 'icon' => 'fas fa-address-card', 'route' => 'admin.ppdb.index', 'pattern' => 'admin.ppdb.*'],
                    ['label' => 'Galeri', 'icon' => 'fas fa-images', 'route' => 'admin.galleries.index', 'pattern' => 'admin.galleries.*'],
                    ['label' => 'Galeri Video', 'icon' => 'fas fa-video', 'route' => 'admin.gallery-videos.index', 'pattern' => 'admin.gallery-videos.*'],
                    ['label' => 'Pesan', 'icon' => 'fas fa-inbox', 'route' => 'admin.messages.index', 'pattern' => 'admin.messages.*'],
                    ['label' => 'Pengguna', 'icon' => 'fas fa-users-cog', 'route' => 'admin.users.index', 'pattern' => 'admin.users.*'],
                    ['label' => 'Log Aktivitas', 'icon' => 'fas fa-clipboard-list', 'route' => 'admin.logs.index', 'pattern' => 'admin.logs.index'],
                ];
                @endphp

                <nav class="sidebar-menu-card">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header-label">Menu Utama</li>
                        @foreach($menuItems as $item)
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
