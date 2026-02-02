<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi SMP Negeri 4 Samarinda - Berprestasi, Berkarakter, dan Berbudaya Lingkungan">
    <meta name="theme-color" content="#003366">

    <title>SMP Negeri 4 Samarinda</title>

    <!-- Fonts: Poppins & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Top Bar -->
    <div class="bg-light py-1 d-none d-lg-block small border-bottom">
        <div class="container d-flex justify-content-between align-items-center text-muted">
            <div>
                <i class="fas fa-envelope me-2"></i> info@smpn4samarinda.sch.id
                <span class="mx-2">|</span>
                <i class="fas fa-phone me-2"></i> (0541) 741234
            </div>
            <div>
                <a href="#" class="text-muted me-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-muted me-2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-muted"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Nav -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <!-- PERBAIKAN: Menghapus markdown syntax dari URL gambar dan menambahkan onerror -->
                <img src="{{ asset('img/logo-smp4.jpg') }}" alt="Logo" class="bg-white rounded-circle p-1" height="45" onerror="this.style.display='none'">
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
                            <li><a class="dropdown-item" href="{{ route('profil') }}#identitas">Identitas Sekolah</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#sejarah">Sejarah</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#visi">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}#struktur">Struktur Organisasi</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">GTK</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('guru') }}">Kepala Sekolah & Guru</a></li>
                            <li><a class="dropdown-item" href="#">Tenaga Kependidikan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Akademik</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('akademik') }}">Kurikulum</a></li>
                            <li><a class="dropdown-item" href="#">Muatan Lokal</a></li>
                            <li><a class="dropdown-item" href="#">Program Unggulan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('sarpras') }}">Sarpras</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Informasi</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('informasi') }}">Berita Sekolah</a></li>
                            <li><a class="dropdown-item" href="#">Pengumuman</a></li>
                            <li><a class="dropdown-item" href="#">Agenda</a></li>
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

    <main>
        @yield('content')
    </main>

    <footer class="pt-5 pb-3 mt-5 border-top border-secondary">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3 text-white">Tentang Kami</h5>
                    <p class="small text-white-50">Mewujudkan generasi beriman, berilmu, dan berakhlak mulia.</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5 class="mb-3 text-white">Kontak</h5>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-warning"></i> Jl. Juanda No. 123, Samarinda</li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-warning"></i> (0541) 741234</li>
                        <li><i class="fas fa-envelope me-2 text-warning"></i> info@smpn4samarinda.sch.id</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary mt-4 opacity-25">
            <div class="text-center small text-white-50">&copy; {{ date('Y') }} SMP Negeri 4 Samarinda.</div>
        </div>
    </footer>

    <!-- PERBAIKAN: Menghapus markdown syntax pada script src -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
