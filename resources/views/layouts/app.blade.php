<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi SMP Negeri 4 Samarinda - Berprestasi, Berkarakter, dan Berbudaya Lingkungan">
    <meta name="theme-color" content="#003366">

    @php
        $publicProfile = cache()->remember('school_profile_public', 60, function () {
            return \App\Models\SchoolProfile::select([
                'nama_sekolah',
                'alamat',
                'email',
                'telepon',
                'footer_description',
                'facebook_url',
                'instagram_url',
                'youtube_url',
                'logo_path',
                'whatsapp_number',
            ])->first();
        });

        $schoolEmail = optional($publicProfile)->email ?? 'info@smpn4samarinda.sch.id';
        $schoolPhone = optional($publicProfile)->telepon ?? '(0541) 741234';
        $schoolAddress = optional($publicProfile)->alamat ?? 'Jl. Juanda No. 123, Samarinda';
        $footerDescription = optional($publicProfile)->footer_description ?? 'Mewujudkan generasi beriman, berilmu, dan berakhlak mulia.';

        $socialLinks = collect([
            'facebook' => optional($publicProfile)->facebook_url,
            'instagram' => optional($publicProfile)->instagram_url,
            'youtube' => optional($publicProfile)->youtube_url,
        ])->filter();

        $cachedFaviconPath = cache()->remember('school_profile_favicon', 60, function () {
            return \Illuminate\Support\Facades\Storage::disk('public')->exists('branding/favicon.ico')
                ? 'branding/favicon.ico'
                : null;
        });
        $faviconUrl = $cachedFaviconPath ? asset('storage/' . $cachedFaviconPath) : asset('img/logo-smp4.jpg');
        $logoPath = optional($publicProfile)->logo_path;
        $schoolLogoUrl = $logoPath ? asset('storage/' . $logoPath) : asset('img/logo-smp4.jpg');
    @endphp

    <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $faviconUrl }}" type="image/x-icon">

    <title>SMP Negeri 4 Samarinda</title>

    <!-- Fonts: Poppins & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/whatsapp-button.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="bg-light py-1 d-none d-lg-block small border-bottom">
        <div class="container d-flex justify-content-between align-items-center text-muted">
            <div>
                <i class="fas fa-envelope me-2"></i> {{ $schoolEmail }}
                <span class="mx-2">|</span>
                <i class="fas fa-phone me-2"></i> {{ $schoolPhone }}
            </div>
            <div>
                @foreach($socialLinks as $platform => $url)
                    <a href="{{ $url }}" class="text-muted me-2" target="_blank" rel="noopener">
                        <i class="fab fa-{{ $platform }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Nav -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ $schoolLogoUrl }}" alt="Logo" class="bg-white rounded-circle p-1" height="45" onerror="this.style.display='none'">
                <div class="d-flex flex-column">
                    <span class="fw-bold fs-5 lh-1">SMP NEGERI 4</span>
                    <span class="fs-6 fw-light text-warning" style="font-size: 0.75rem;">SAMARINDA</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Profil Sekolah</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profil') }}#sejarah">Sejarah</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#identitas">Identitas Sekolah</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#visi">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#struktur">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#riwayat-kepsek">Riwayat Kepala Sekolah</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">GTK</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('guru') }}#pendidik">Kepala Sekolah & Guru</a></li>
                            <li><a class="dropdown-item" href="{{ route('guru') }}#tendik">Tenaga Kependidikan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Akademik</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('akademik') }}#kurikulum">Kurikulum</a></li>
                            <li><a class="dropdown-item" href="{{ route('akademik') }}#muatan-lokal">Muatan Lokal</a></li>
                            <li><a class="dropdown-item" href="{{ route('akademik') }}#program-unggulan">Program Unggulan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('sarpras') }}">Sarpras</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Informasi</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-semibold text-primary" href="{{ route('informasi') }}">Halaman Informasi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('informasi', ['kategori' => 'berita']) }}">Berita Sekolah</a></li>
                            <li><a class="dropdown-item" href="{{ route('informasi', ['kategori' => 'informasi']) }}">Informasi Umum</a></li>
                            <li><a class="dropdown-item" href="{{ route('informasi', ['kategori' => 'pengumuman']) }}">Pengumuman</a></li>
                            <li><a class="dropdown-item" href="{{ route('informasi', ['kategori' => 'agenda']) }}">Agenda</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link text-warning fw-bold" href="{{ route('ppdb') }}">PPDB</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('galeri') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kontak') }}">Kontak</a></li>

                    @auth
                        <li class="nav-item ms-lg-2"><a class="btn btn-warning btn-sm fw-bold rounded-pill px-3" href="{{ route('admin.dashboard') }}">Admin</a></li>
                    @else
                        <li class="nav-item ms-lg-2"><a class="btn btn-outline-light btn-sm fw-bold rounded-pill px-3" href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(auth()->check() && request()->routeIs('admin.*'))
        @php
            $adminMenu = [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fa-gauge', 'pattern' => 'admin.dashboard'],
                ['label' => 'Berita', 'route' => 'admin.posts.index', 'icon' => 'fa-newspaper', 'pattern' => 'admin.posts.*'],
                ['label' => 'Slider', 'route' => 'admin.home-sliders.index', 'icon' => 'fa-images', 'pattern' => 'admin.home-sliders.*'],
                ['label' => 'GTK', 'route' => 'admin.teachers.index', 'icon' => 'fa-user-graduate', 'pattern' => 'admin.teachers.*'],
                ['label' => 'Fasilitas', 'route' => 'admin.facilities.index', 'icon' => 'fa-building', 'pattern' => 'admin.facilities.*'],
                ['label' => 'Akademik', 'route' => 'admin.academic.edit', 'icon' => 'fa-graduation-cap', 'pattern' => 'admin.academic.*'],
                ['label' => 'PPDB', 'route' => 'admin.ppdb.index', 'icon' => 'fa-address-card', 'pattern' => 'admin.ppdb.*'],
                ['label' => 'Galeri', 'route' => 'admin.galleries.index', 'icon' => 'fa-images', 'pattern' => 'admin.galleries.*'],
                ['label' => 'Pesan', 'route' => 'admin.messages.index', 'icon' => 'fa-inbox', 'pattern' => 'admin.messages.*'],
                ['label' => 'Log Aktivitas', 'route' => 'admin.logs.index', 'icon' => 'fa-clipboard-list', 'pattern' => 'admin.logs.index'],
            ];
        @endphp
        <div class="bg-dark text-white border-bottom border-warning border-opacity-25 shadow-sm">
            <div class="container py-2 d-flex flex-wrap align-items-center gap-2">
                <span class="text-uppercase small text-warning fw-semibold me-2">Menu Admin</span>
                @foreach($adminMenu as $item)
                    @php $isActive = request()->routeIs($item['pattern']); @endphp
                    <a href="{{ route($item['route']) }}" class="btn btn-sm d-flex align-items-center gap-2 {{ $isActive ? 'btn-warning text-dark fw-semibold shadow-sm border-0' : 'btn-outline-light text-white-50 border-opacity-25' }}">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('components.whatsapp-button', [
        'whatsappNumber' => optional($publicProfile)->whatsapp_number,
    ])

    <footer class="pt-5 pb-3 mt-5 border-top border-secondary">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3 text-white">Tentang Kami</h5>
                    <p class="small text-white-50">{{ $footerDescription }}</p>
                    <div class="mt-3">
                        @forelse($socialLinks as $platform => $url)
                            <a href="{{ $url }}" class="text-white me-3" target="_blank" rel="noopener">
                                <i class="fab fa-{{ $platform }} fa-lg"></i>
                            </a>
                        @empty
                            <span class="small text-white-50">Ikuti kami di media sosial.</span>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5 class="mb-3 text-white">Kontak</h5>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-warning"></i> {{ $schoolAddress }}</li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-warning"></i> {{ $schoolPhone }}</li>
                        <li><i class="fas fa-envelope me-2 text-warning"></i> {{ $schoolEmail }}</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary mt-4 opacity-25">
            <div class="text-center small text-white-50">&copy; {{ date('Y') }} {{ optional($publicProfile)->nama_sekolah ?? 'SMP Negeri 4 Samarinda' }}.</div>
        </div>
            <div class="text-center mt-1">
    <a href="https://www.instagram.com/arifwbo"
       class="text-white-50 text-decoration-none"
       target="_blank" rel="noopener">
        Developed by arifwbo
    </a>
</div>

    </footer>

    <!-- PERBAIKAN: Menghapus markdown syntax pada script src -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/whatsapp-button.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')
</body>
</html>
