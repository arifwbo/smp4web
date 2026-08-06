<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi SMP Negeri 4 Samarinda - Berprestasi, Berkarakter, dan Berbudaya Lingkungan">
    <meta name="theme-color" content="#1e3a8a">
    @php
        $currentUser = auth()->user();
        $adminMenu = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fa-gauge', 'pattern' => 'admin.dashboard', 'permission' => 'dashboard.view'],
            ['label' => 'Berita', 'route' => 'admin.posts.index', 'icon' => 'fa-newspaper', 'pattern' => 'admin.posts.*', 'permission' => ['posts.manage', 'posts.academic', 'posts.sarpras']],
            ['label' => 'Slider', 'route' => 'admin.home-sliders.index', 'icon' => 'fa-images', 'pattern' => 'admin.home-sliders.*', 'permission' => 'sliders.manage'],
            ['label' => 'GTK', 'route' => 'admin.teachers.index', 'icon' => 'fa-user-graduate', 'pattern' => 'admin.teachers.*', 'permission' => 'teachers.manage'],
            ['label' => 'Fasilitas', 'route' => 'admin.facilities.index', 'icon' => 'fa-building', 'pattern' => 'admin.facilities.*', 'permission' => 'facilities.manage'],
            ['label' => 'Akademik', 'route' => 'admin.academic.edit', 'icon' => 'fa-graduation-cap', 'pattern' => 'admin.academic.*', 'permission' => 'academic.manage'],
            ['label' => 'PPDB', 'route' => 'admin.ppdb.index', 'icon' => 'fa-address-card', 'pattern' => 'admin.ppdb.*', 'permission' => 'ppdb.manage'],
            ['label' => 'Galeri', 'route' => 'admin.galleries.index', 'icon' => 'fa-images', 'pattern' => 'admin.galleries.*', 'permission' => 'galleries.manage'],
            ['label' => 'Pesan', 'route' => 'admin.messages.index', 'icon' => 'fa-inbox', 'pattern' => 'admin.messages.*', 'permission' => 'messages.view'],
            ['label' => 'Log Aktivitas', 'route' => 'admin.logs.index', 'icon' => 'fa-clipboard-list', 'pattern' => 'admin.logs.index', 'permission' => 'activity.logs.view'],
        ];

        $publicProfile = cache()->remember('layout_public_profile', 300, function () {
            return \App\Models\SchoolProfile::select([
                'nama_sekolah',
                'email',
                'telepon',
                'alamat',
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

    <!-- Fonts: Inter & Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/whatsapp-button.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Top Scroll Progress Bar -->
    <div id="scroll-progress"></div>

    <!-- Top Bar -->
    <div class="topbar-custom py-2 d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <span><i class="fas fa-envelope me-2 opacity-75"></i> {{ $schoolEmail }}</span>
                <span class="opacity-25 mx-1">|</span>
                <span><i class="fas fa-phone me-2 opacity-75"></i> {{ $schoolPhone }}</span>
                <span class="opacity-25 mx-1">|</span>
                <span><i class="fas fa-map-marker-alt me-2 opacity-75"></i> {{ $schoolAddress }}</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                @foreach($socialLinks as $platform => $url)
                    <a href="{{ $url }}" class="social-btn" target="_blank" rel="noopener" aria-label="{{ $platform }}">
                        <i class="fab fa-{{ $platform }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Nav -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ url('/') }}">
                <img src="{{ $schoolLogoUrl }}" alt="Logo SMPN 4" height="42" onerror="this.style.display='none'">
                <div class="d-flex flex-column">
                    <span class="fw-extrabold fs-5 lh-1 text-white display-font">SMP NEGERI 4</span>
                    <span class="fw-bold" style="color:var(--gold); font-size: 0.75rem; letter-spacing: 1.5px;">SAMARINDA</span>
                </div>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('profil') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">Profil</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profil') }}">Profil Lengkap</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#sejarah">Sejarah</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#identitas">Identitas Sekolah</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#visi">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#struktur">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#riwayat-kepsek">Riwayat Kepala Sekolah</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('guru') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">GTK</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('guru') }}#pendidik">Kepala Sekolah & Guru</a></li>
                            <li><a class="dropdown-item" href="{{ route('guru') }}#tendik">Tenaga Kependidikan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('akademik') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">Akademik</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-semibold" href="{{ route('akademik') }}">Halaman Akademik</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('akademik') }}#kurikulum">Kurikulum</a></li>
                            <li><a class="dropdown-item" href="{{ route('akademik') }}#muatan-lokal">Muatan Lokal</a></li>
                            <li><a class="dropdown-item" href="{{ route('akademik') }}#program-unggulan">Program Unggulan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('sarpras') ? 'active' : '' }}" href="{{ route('sarpras') }}">Sarpras</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('informasi') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">Informasi</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-semibold" href="{{ route('informasi') }}">Halaman Informasi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('informasi', ['kategori' => 'berita']) }}">Berita Sekolah</a></li>
                            <li><a class="dropdown-item" href="{{ route('informasi', ['kategori' => 'informasi']) }}">Informasi Umum</a></li>
                            <li><a class="dropdown-item" href="{{ route('informasi', ['kategori' => 'pengumuman']) }}">Pengumuman</a></li>
                            <li><a class="dropdown-item" href="{{ route('informasi', ['kategori' => 'agenda']) }}">Agenda</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link fw-bold {{ request()->routeIs('ppdb') ? 'active' : '' }}" style="color: var(--gold) !important;" href="{{ route('ppdb') }}">PPDB</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ route('galeri') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold {{ request()->routeIs('aplikasi') ? 'active' : '' }}" style="color: var(--accent-soft) !important;" href="{{ route('aplikasi') }}">Portal</a></li>

                    @auth
                        <li class="nav-item ms-lg-2"><a class="btn btn-accent-custom btn-sm fw-bold rounded-pill px-3 shadow-sm text-dark" href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge me-1"></i> Dashboard</a></li>
                    @else
                        <li class="nav-item ms-lg-2"><a class="btn btn-outline-light btn-sm fw-bold rounded-pill px-3 shadow-sm" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login</a></li>
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
                ['label' => 'Portal Aplikasi', 'route' => 'admin.application-links.index', 'icon' => 'fa-sitemap', 'pattern' => 'admin.application-links.*'],
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
                    @php
                        $permissions = (array) ($item['permission'] ?? []);
                        $canSee = empty($permissions) || ($currentUser && collect($permissions)->contains(fn ($perm) => $currentUser->hasPermission($perm)));
                        $isActive = request()->routeIs($item['pattern']);
                    @endphp
                    @if(! $canSee)
                        @continue
                    @endif
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

    <!-- Floating Action Button Group -->
    <div class="fab-group" id="fabGroup">
        <!-- Back to Top -->
        <button type="button" class="fab-btn fab-top" id="back-to-top" aria-label="Kembali ke atas" title="Kembali ke atas">
            <i class="fas fa-arrow-up"></i>
        </button>

        <!-- WhatsApp -->
        @php
            $waNumber  = optional($publicProfile)->whatsapp_number ?: '6281355577799';
            $waMessage = 'Halo Admin SMP Negeri 4 Samarinda, saya ingin bertanya informasi sekolah.';
        @endphp
        <a  class="fab-btn fab-wa"
            href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waMessage) }}"
            target="_blank" rel="noopener noreferrer"
            aria-label="Hubungi via WhatsApp"
            title="Hubungi via WhatsApp">
            <svg width="26" height="26" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                <path fill="currentColor" d="M16 3a13 13 0 0 0-11.2 19.4L3 29l6.8-1.8A13 13 0 1 0 16 3zm0 2.4a10.6 10.6 0 0 1 9.2 16 1 1 0 0 1-.1 1.1 1 1 0 0 1-1.1.3 8.8 8.8 0 0 0-2.8-.5c-5.6 0-10.2 4.1-11.1 9.6l-.5 3.1L7 26.2a1 1 0 0 1-.4-1.2 10.6 10.6 0 0 1 9.4-19.6zm4.4 6.6c-.2-.4-.4-.3-.6-.4h-.6a1.2 1.2 0 0 0-.8.3 2.6 2.6 0 0 0-.9 1.9 4.5 4.5 0 0 0 1 2.3 8.8 8.8 0 0 0 1.8 2.1 6.9 6.9 0 0 0 2.5 1.4c.4.1.7.2 1 .2a2.2 2.2 0 0 0 1.4-.6 1.6 1.6 0 0 0 .2-1.2 7.2 7.2 0 0 0-.3-.7l-.5-1.3c-.1-.2-.2-.3-.4-.4l-1-.2-.6.2s-.3.5-.4.5-.3 0-.5-.2a4.9 4.9 0 0 1-1.5-1.2 5 5 0 0 1-1-1.4c-.2-.4 0-.5.1-.7l.3-.4.2-.5a.8.8 0 0 0-.2-.6c-.1 0-.2-.3-.4-.3z"/>
            </svg>
        </a>
    </div>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $schoolLogoUrl }}" alt="Logo" class="bg-white rounded-circle p-1" height="42" onerror="this.style.display='none'">
                        <span class="footer-brand-name">SMP NEGERI 4 SAMARINDA</span>
                    </div>
                    <p class="footer-desc mb-4">{{ $footerDescription }}</p>
                    <div class="footer-social">
                        @forelse($socialLinks as $platform => $url)
                            <a href="{{ $url }}" class="footer-social-btn" target="_blank" rel="noopener" aria-label="{{ $platform }}">
                                <i class="fab fa-{{ $platform }}"></i>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="footer-heading">Navigasi Utama</div>
                    <a href="{{ route('home') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Beranda</a>
                    <a href="{{ route('profil') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Profil Sekolah</a>
                    <a href="{{ route('guru') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Guru & GTK</a>
                    <a href="{{ route('akademik') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Akademik</a>
                    <a href="{{ route('sarpras') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Sarana Prasarana</a>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="footer-heading">Layanan & Info</div>
                    <a href="{{ route('ppdb') }}" class="footer-link"><i class="fas fa-chevron-right"></i> PPDB Online</a>
                    <a href="{{ route('aplikasi') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Portal Aplikasi</a>
                    <a href="{{ route('informasi') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Berita & Info</a>
                    <a href="{{ route('galeri') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Galeri Kegiatan</a>
                    <a href="{{ route('kontak') }}" class="footer-link"><i class="fas fa-chevron-right"></i> Hubungi Kami</a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-heading">Kontak Resmi</div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <span class="small">{{ $schoolAddress }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-phone"></i></div>
                        <span class="small">{{ $schoolPhone }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-envelope"></i></div>
                        <span class="small">{{ $schoolEmail }}</span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>&copy; {{ date('Y') }} {{ optional($publicProfile)->nama_sekolah ?? 'SMP Negeri 4 Samarinda' }}. All Rights Reserved.</div>
                <div>
                    <a href="https://www.instagram.com/arifwbo" class="text-white-50 text-decoration-none" target="_blank" rel="noopener">
                        Developed by <span style="color:var(--gold);" class="fw-semibold">arifwbo</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts: Bootstrap 5, AOS, GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="{{ asset('js/whatsapp-button.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <!-- Custom JS handles AOS, scroll events, and animations -->
    @stack('scripts')
</body>
</html>
