<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-link .brand-text {
            letter-spacing: 0.05em;
        }

        .nav-sidebar .nav-link {
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            transition: all 0.2s ease;
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
            color: rgba(255, 255, 255, 0.7);
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

        .main-header .badge-notif {
            background: var(--admin-accent);
            color: #1f2937;
            font-weight: 600;
        }
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
            <img src="{{ asset('img/logo-smp4.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.9" onerror="this.style.display='none'">
            <span class="brand-text font-weight-semibold">SMPN 4 Admin</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email ?? 'admin@smpn4.test'))) }}?s=160&d=identicon" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name ?? 'Administrator' }}</a>
                    <span class="text-muted small">Admin</span>
                </div>
            </div>

            @php
                $menuItems = [
                    ['label' => 'Dashboard', 'icon' => 'fas fa-gauge', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard'],
                    ['label' => 'Profil Sekolah', 'icon' => 'fas fa-school', 'route' => 'admin.profile.edit', 'pattern' => 'admin.profile.*'],
                    ['label' => 'Slider Beranda', 'icon' => 'fas fa-images', 'route' => 'admin.home-sliders.index', 'pattern' => 'admin.home-sliders.*'],
                    ['label' => 'Berita', 'icon' => 'fas fa-newspaper', 'route' => 'admin.posts.index', 'pattern' => 'admin.posts.*'],
                    ['label' => 'GTK', 'icon' => 'fas fa-user-graduate', 'route' => 'admin.teachers.index', 'pattern' => 'admin.teachers.*'],
                    ['label' => 'Fasilitas', 'icon' => 'fas fa-building', 'route' => 'admin.facilities.index', 'pattern' => 'admin.facilities.*'],
                    ['label' => 'Halaman Akademik', 'icon' => 'fas fa-graduation-cap', 'route' => 'admin.academic.edit', 'pattern' => 'admin.academic.*'],
                    ['label' => 'PPDB', 'icon' => 'fas fa-address-card', 'route' => 'admin.ppdb.index', 'pattern' => 'admin.ppdb.*'],
                    ['label' => 'Galeri', 'icon' => 'fas fa-images', 'route' => 'admin.galleries.index', 'pattern' => 'admin.galleries.*'],
                    ['label' => 'Pesan', 'icon' => 'fas fa-inbox', 'route' => 'admin.messages.index', 'pattern' => 'admin.messages.*'],
                    ['label' => 'Log Aktivitas', 'icon' => 'fas fa-clipboard-list', 'route' => 'admin.logs.index', 'pattern' => 'admin.logs.index'],
                ];
            @endphp

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
        <span class="float-right d-none d-sm-inline">Versi AdminLTE</span>
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

    document.addEventListener('DOMContentLoaded', initWysiwygEditors);
</script>
@stack('scripts')
</body>
</html>
