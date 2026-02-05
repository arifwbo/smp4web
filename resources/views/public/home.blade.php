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
        <div class="col-lg-3 col-md-6">
            <div class="info-card-item text-center">
                <div class="info-icon"><i class="fas fa-school"></i></div>
                <h4 class="fw-bold mb-3">Identitas Sekolah</h4>
                <p class="text-muted small">Mengenal lebih dekat sejarah, visi, misi, dan tujuan sekolah.</p>
                <a href="{{ route('profil') }}" class="btn btn-link text-decoration-none fw-bold text-primary-custom">Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="info-card-item text-center">
                <div class="info-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h4 class="fw-bold mb-3">Guru & Tendik</h4>
                <p class="text-muted small">Daftar pendidik dan tenaga kependidikan yang profesional.</p>
                <a href="{{ route('guru') }}" class="btn btn-link text-decoration-none fw-bold text-primary-custom">Lihat Data <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="info-card-item text-center">
                <div class="info-icon"><i class="fas fa-user-graduate"></i></div>
                <h4 class="fw-bold mb-3">PPDB Online</h4>
                <p class="text-muted small">Informasi pendaftaran siswa baru, jadwal, dan persyaratan.</p>
                <a href="{{ route('ppdb') }}" class="btn btn-link text-decoration-none fw-bold text-primary-custom">Daftar Sekarang <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="info-card-item text-center">
                <div class="info-icon"><i class="fas fa-bullhorn"></i></div>
                <h4 class="fw-bold mb-3">Pengumuman</h4>
                <p class="text-muted small mb-3">
                    {{ $latestPengumuman ? Str::limit(strip_tags($latestPengumuman->judul), 80) : 'Belum ada pengumuman terbaru. Pantau terus laman informasi sekolah.' }}
                </p>
                <a href="{{ $latestPengumuman ? route('berita.detail', $latestPengumuman->slug) : route('informasi', ['kategori' => 'pengumuman']) }}" class="btn btn-link text-decoration-none fw-bold text-primary-custom">
                    {{ $latestPengumuman ? 'Baca Pengumuman' : 'Lihat Semua Pengumuman' }} <i class="fas fa-arrow-right"></i>
                </a>
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

@if($featuredTeachers->isNotEmpty())
@php
    $shuffledTeachers = $featuredTeachers->shuffle();
    $gtkSlides = $shuffledTeachers->chunk(3);
    $teacherDataset = $featuredTeachers->map(function ($teacher) {
        return [
            'nama' => $teacher->nama,
            'jabatan' => $teacher->jabatan ?? 'Tenaga Kependidikan',
            'nip' => $teacher->nip,
            'jenis' => $teacher->jenis ? strtoupper($teacher->jenis) : null,
            'foto' => $teacher->foto
                ? asset('storage/' . $teacher->foto)
                : 'https://ui-avatars.com/api/?name=' . urlencode($teacher->nama) . '&background=003366&color=ffffff',
        ];
    });
@endphp
<section class="py-5 gtk-highlight" id="gtk-highlight">
    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center text-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold text-primary-custom mb-0">Guru &amp; Tenaga Kependidikan</h2>
            </div>
            <a href="{{ route('guru') }}" class="btn btn-primary-custom rounded-pill px-4 shadow-sm">Lihat Daftar Lengkap</a>
        </div>

        <div id="gtkCarousel" class="carousel slide gtk-carousel" data-bs-ride="carousel" data-bs-interval="4800" data-bs-touch="true">
            <div class="carousel-inner">
                @foreach($gtkSlides as $slide)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row g-4 justify-content-center">
                            @foreach($slide as $teacher)
                                @php
                                    $photoUrl = $teacher->foto
                                        ? asset('storage/' . $teacher->foto)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($teacher->nama) . '&background=003366&color=ffffff';
                                @endphp
                                <div class="col-md-4">
                                    <div class="gtk-card text-center h-100">
                                        <div class="gtk-photo mb-3">
                                            <img src="{{ $photoUrl }}" alt="{{ $teacher->nama }}" loading="lazy">
                                        </div>
                                        <h5 class="fw-bold mb-1">{{ $teacher->nama }}</h5>
                                        <p class="text-muted small mb-2">{{ $teacher->jabatan ?? 'Tenaga Kependidikan' }}</p>
                                        @if($teacher->nip)
                                            <p class="text-muted small mb-2">NIP: {{ $teacher->nip }}</p>
                                        @endif
                                        @if($teacher->jenis)
                                            <span class="badge bg-warning text-dark">{{ Str::upper($teacher->jenis) }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            @if($gtkSlides->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#gtkCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Sebelumnya</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#gtkCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Berikutnya</span>
                </button>
            @endif
        </div>
    </div>
</section>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const gtkCarousel = document.getElementById('gtkCarousel');
    const teacherPool = @json($teacherDataset);

    if (!gtkCarousel || !Array.isArray(teacherPool) || teacherPool.length === 0) {
        return;
    }

    const slides = gtkCarousel.querySelectorAll('.carousel-item');
    if (!slides.length) {
        return;
    }

    const shuffleArray = (array) => {
        const arr = [...array];
        for (let i = arr.length - 1; i > 0; i -= 1) {
            const j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
        return arr;
    };

    const buildCard = (teacher) => {
        const col = document.createElement('div');
        col.className = 'col-md-4';

        const card = document.createElement('div');
        card.className = 'gtk-card text-center h-100';

        const photoWrapper = document.createElement('div');
        photoWrapper.className = 'gtk-photo mb-3';

        const img = document.createElement('img');
        img.src = teacher.foto;
        img.alt = teacher.nama;
        img.loading = 'lazy';
        photoWrapper.appendChild(img);
        card.appendChild(photoWrapper);

        const nameEl = document.createElement('h5');
        nameEl.className = 'fw-bold mb-1';
        nameEl.textContent = teacher.nama;
        card.appendChild(nameEl);

        if (teacher.jabatan) {
            const roleEl = document.createElement('p');
            roleEl.className = 'text-muted small mb-2';
            roleEl.textContent = teacher.jabatan;
            card.appendChild(roleEl);
        }

        if (teacher.nip) {
            const nipEl = document.createElement('p');
            nipEl.className = 'text-muted small mb-2';
            nipEl.textContent = `NIP: ${teacher.nip}`;
            card.appendChild(nipEl);
        }

        if (teacher.jenis) {
            const badge = document.createElement('span');
            badge.className = 'badge bg-warning text-dark';
            badge.textContent = teacher.jenis;
            card.appendChild(badge);
        }

        col.appendChild(card);
        return col;
    };

    const renderSlides = () => {
        const randomized = shuffleArray(teacherPool);
        slides.forEach((slide, index) => {
            const row = slide.querySelector('.row');
            if (!row) {
                return;
            }

            row.innerHTML = '';
            const start = index * 3;
            let chunk = randomized.slice(start, start + 3);

            if (chunk.length < 3) {
                const replenished = shuffleArray(teacherPool);
                chunk = chunk.concat(replenished.slice(0, 3 - chunk.length));
            }

            chunk.forEach((teacher) => {
                row.appendChild(buildCard(teacher));
            });
        });
    };

    renderSlides();

    gtkCarousel.addEventListener('slid.bs.carousel', (event) => {
        if (typeof event.to === 'number' && event.to === 0) {
            renderSlides();
        }
    });
});
</script>
@endpush
@endif

<!-- BERITA & AGENDA -->
<section class="py-5 bg-white" id="berita">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary-custom">Berita & Informasi</h2>
            <p class="text-muted">Update kegiatan dan informasi terkini dari sekolah.</p>
            <a href="{{ route('informasi') }}" class="btn btn-outline-primary rounded-pill px-4">Lihat Semua Berita & Informasi</a>
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
                    <div id="pengumuman">
                        <h4 class="fw-bold mb-3 text-primary-custom">Pengumuman</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($pengumuman as $info)
                            <li class="list-group-item bg-transparent border-0 px-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold"><a href="{{ route('berita.detail', $info->slug) }}" class="text-dark text-decoration-none">{{ $info->judul }}</a></h6>
                                </div>
                                <small class="text-muted">{{ $info->created_at->format('d M Y') }}</small>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr class="my-4">
                    <div id="agenda">
                        <h4 class="fw-bold mb-3 text-primary-custom">Agenda Kegiatan</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($agenda as $ag)
                            <li class="list-group-item bg-transparent border-0 px-0">
                                <span class="badge bg-warning text-dark mb-1">Agenda</span>
                                <h6 class="mb-1 fw-bold"><a href="{{ route('berita.detail', $ag->slug) }}" class="text-dark text-decoration-none">{{ $ag->judul }}</a></h6>
                                <small class="text-muted">{{ $ag->created_at->format('d M Y') }}</small>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GALERI TERBARU -->
<section class="py-5 bg-light border-top" id="galeri-terbaru">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary-custom">Galeri Terbaru</h2>
            <p class="text-muted mb-0">Cuplikan singkat video dan foto aktivitas terbaru di SMPN 4 Samarinda.</p>
            <a href="{{ route('galeri') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3">Lihat Semua Koleksi</a>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="bg-white rounded-4 shadow-sm h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Video Terbaru</h5>
                        <span class="badge bg-primary">{{ $latestVideos->count() }} Video</span>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @forelse($latestVideos as $video)
                        <div class="card border-0 shadow-sm">
                            <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                                <iframe src="{{ $video->embed_url }}" title="{{ $video->judul }}" allowfullscreen loading="lazy"></iframe>
                            </div>
                            <div class="card-body">
                                <h6 class="fw-semibold mb-1">{{ $video->judul }}</h6>
                                <p class="text-muted small mb-2">{{ Str::limit($video->deskripsi, 80) }}</p>
                                <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">Buka di YouTube</a>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted mb-0">Belum ada video yang diunggah.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white rounded-4 shadow-sm h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Foto Terbaru</h5>
                        <span class="badge bg-success">{{ $latestPhotos->count() }} Foto</span>
                    </div>
                    <div class="row g-3">
                        @forelse($latestPhotos as $photo)
                        <div class="col-6">
                            <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm position-relative">
                                <img src="{{ asset('storage/' . $photo->gambar) }}" alt="{{ $photo->judul }}" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white small px-2 py-1">{{ Str::limit($photo->judul, 30) }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-muted mb-0">Belum ada foto terbaru.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
