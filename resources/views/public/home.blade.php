@extends('layouts.app')

@section('content')
<!-- HERO SLIDER -->
<div id="schoolCarousel" class="carousel slide hero-slider carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#schoolCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#schoolCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#schoolCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1920" class="d-block w-100" alt="Sekolah">
            <div class="carousel-caption hero-caption">
                <h1 class="hero-title">Selamat Datang di<br>SMP Negeri 4 Samarinda</h1>
                <p class="hero-subtitle">Mewujudkan Generasi Berprestasi, Berkarakter, dan Berwawasan Lingkungan.</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('profil') }}" class="btn btn-warning fw-bold px-4 py-2 rounded-pill shadow">Profil Sekolah</a>
                    <a href="{{ route('ppdb') }}" class="btn btn-outline-light fw-bold px-4 py-2 rounded-pill">Info PPDB</a>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1920" class="d-block w-100" alt="Belajar">
            <div class="carousel-caption hero-caption">
                <h1 class="hero-title">Pembelajaran Aktif &<br>Menyenangkan</h1>
                <p class="hero-subtitle">Didukung fasilitas lengkap dan tenaga pengajar profesional.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1577896337318-2838d43f6c6d?q=80&w=1920" class="d-block w-100" alt="Prestasi">
            <div class="carousel-caption hero-caption">
                <h1 class="hero-title">Raih Prestasi<br>Gemilang</h1>
                <p class="hero-subtitle">Mengembangkan potensi siswa baik akademik maupun non-akademik.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#schoolCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
    <button class="carousel-control-next" type="button" data-bs-target="#schoolCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
</div>

<!-- INFO CARDS -->
<div class="container info-cards">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="info-card-item text-center">
                <div class="info-icon"><i class="fas fa-school"></i></div>
                <h4 class="fw-bold mb-3">Identitas Sekolah</h4>
                <p class="text-muted small">Mengenal lebih dekat sejarah, visi, misi, dan tujuan sekolah.</p>
                <a href="{{ route('profil') }}" class="btn btn-link text-decoration-none fw-bold text-primary-custom">Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card-item text-center">
                <div class="info-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h4 class="fw-bold mb-3">Guru & Tendik</h4>
                <p class="text-muted small">Daftar pendidik dan tenaga kependidikan yang profesional.</p>
                <a href="{{ route('guru') }}" class="btn btn-link text-decoration-none fw-bold text-primary-custom">Lihat Data <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card-item text-center">
                <div class="info-icon"><i class="fas fa-user-graduate"></i></div>
                <h4 class="fw-bold mb-3">PPDB Online</h4>
                <p class="text-muted small">Informasi pendaftaran siswa baru, jadwal, dan persyaratan.</p>
                <a href="{{ route('ppdb') }}" class="btn btn-link text-decoration-none fw-bold text-primary-custom">Daftar Sekarang <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- SAMBUTAN -->
<section class="py-5 mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <img src="https://via.placeholder.com/400x500" class="img-fluid rounded shadow-lg w-100" alt="Kepala Sekolah">
            </div>
            <div class="col-lg-7 ps-lg-5">
                <h6 class="text-primary-custom fw-bold text-uppercase">Sambutan Kepala Sekolah</h6>
                <h2 class="fw-bold mb-4">{{ $profil?->kepala_sekolah ?? 'Kepala Sekolah' }}</h2>
                <p class="text-muted lh-lg mb-4">{{ Str::limit($profil?->sambutan_kepsek ?? 'Selamat datang.', 450) }}</p>
                <a href="{{ route('profil') }}" class="btn btn-primary-custom rounded-pill px-4 shadow">Baca Selengkapnya</a>
            </div>
        </div>
    </div>
</section>

<!-- BERITA & AGENDA -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary-custom">Berita & Informasi</h2>
            <p class="text-muted">Update kegiatan dan informasi terkini dari sekolah.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4">
                    @foreach($berita as $post)
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                            <img src="{{ $post->gambar_url }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><a href="{{ route('berita.detail', $post->slug) }}" class="text-decoration-none text-dark">{{ Str::limit($post->judul, 50) }}</a></h5>
                                <p class="card-text text-muted small">{{ Str::limit(strip_tags($post->isi), 90) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-light p-4 rounded h-100">
                    <h4 class="fw-bold mb-4 text-primary-custom">Agenda & Pengumuman</h4>
                    <ul class="list-group list-group-flush bg-transparent">
                        @foreach($pengumuman as $info)
                        <li class="list-group-item bg-transparent border-0 px-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold"><a href="{{ route('berita.detail', $info->slug) }}" class="text-dark text-decoration-none">{{ $info->judul }}</a></h6>
                            </div>
                            <small class="text-muted">{{ $info->created_at->format('d M Y') }}</small>
                        </li>
                        @endforeach
                        @foreach($agenda as $ag)
                        <li class="list-group-item bg-transparent border-0 px-0">
                            <span class="badge bg-warning text-dark mb-1">Agenda</span>
                            <h6 class="mb-1 fw-bold"><a href="{{ route('berita.detail', $ag->slug) }}" class="text-dark text-decoration-none">{{ $ag->judul }}</a></h6>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
