@extends('layouts.app')

@section('content')
<!-- HERO SLIDER -->
<div id="schoolCarousel" class="carousel slide hero-slider carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach($slides as $index => $slide)
            <button type="button" data-bs-target="#schoolCarousel" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}" {{ $loop->first ? 'aria-current="true"' : '' }}></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($slides as $slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img src="{{ $slide['image_url'] }}" class="d-block w-100" alt="Slider {{ $loop->iteration }}" style="object-fit: cover; min-height: 480px;">
                <div class="carousel-caption hero-caption">
                    <h1 class="hero-title">{!! nl2br(e($slide['title'])) !!}</h1>
                    @if(!empty($slide['subtitle']))
                        <p class="hero-subtitle">{{ $slide['subtitle'] }}</p>
                    @endif
                    @if(!empty($slide['button_label']) && !empty($slide['button_link']))
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ $slide['button_link'] }}" class="btn btn-warning fw-bold px-4 py-2 rounded-pill shadow">{{ $slide['button_label'] }}</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
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

@php
    $kepsekPlaceholder = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="400" height="500" viewBox="0 0 400 500">
    <rect width="400" height="500" fill="#f3f4f6"/>
    <circle cx="200" cy="180" r="90" fill="#dbeafe"/>
    <rect x="90" y="310" width="220" height="130" rx="65" fill="#dbeafe"/>
    <text x="200" y="470" font-size="28" text-anchor="middle" fill="#94a3b8">Kepala Sekolah</text>
</svg>
SVG;
    $kepsekPhoto = $profil?->foto_kepsek
        ? asset('storage/' . $profil->foto_kepsek)
        : 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($kepsekPlaceholder);
@endphp

<!-- SAMBUTAN -->
<section class="py-5 mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-5 mb-4 mb-lg-0">
                <div class="position-relative" style="padding-top: 120%;">
                    <img src="{{ $kepsekPhoto }}" class="position-absolute top-0 start-0 rounded shadow-lg w-100 h-100" style="object-fit: cover;" alt="Kepala Sekolah">
                </div>
            </div>
            <div class="col-lg-8 col-md-7 ps-lg-5">
                <h6 class="text-primary-custom fw-bold text-uppercase">Sambutan Kepala Sekolah</h6>
                <h2 class="fw-bold mb-4">{{ $profil?->kepala_sekolah ?? 'Kepala Sekolah' }}</h2>
                <p class="text-muted lh-lg mb-4">{{ Str::limit(strip_tags($profil?->sambutan_kepsek ?? 'Selamat datang.'), 450) }}</p>
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
