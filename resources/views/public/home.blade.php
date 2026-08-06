@extends('layouts.app')

@section('content')
<!-- HERO SLIDER -->
<div id="schoolCarousel" class="carousel slide hero-slider carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-indicators">
        @foreach($slides as $index => $slide)
            <button
                type="button"
                data-bs-target="#schoolCarousel"
                data-bs-slide-to="{{ $index }}"
                class="{{ $loop->first ? 'active' : '' }}"
                {{ $loop->first ? 'aria-current="true"' : '' }}
            ></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($slides as $slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img src="{{ $slide['image_url'] }}" class="d-block w-100" alt="Slider {{ $loop->iteration }}" onerror="this.onerror=null; this.src='{{ asset('img/placeholder.jpg') }}';">
                <div class="hero-overlay"></div>
                <div class="carousel-caption hero-caption">
                    <div class="hero-badge" data-aos="fade-down" data-aos-delay="100">
                        <i class="fas fa-award"></i> SMP NEGERI 4 SAMARINDA &bull; BERPRESTASI &amp; BERKARAKTER
                    </div>
                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">{!! nl2br(e($slide['title'])) !!}</h1>
                    @if(!empty($slide['subtitle']))
                        <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="300">{{ $slide['subtitle'] }}</p>
                    @endif
                    <div class="d-flex gap-3 justify-content-center flex-wrap" data-aos="fade-up" data-aos-delay="400">
                        @if(!empty($slide['button_label']) && !empty($slide['button_link']))
                            <a href="{{ $slide['button_link'] }}" class="btn btn-accent-custom px-4 py-3">{{ $slide['button_label'] }} <i class="fas fa-arrow-right ms-2"></i></a>
                        @endif
                        <a href="{{ route('profil') }}" class="btn btn-outline-light rounded-pill px-4 py-3 fw-semibold">Jelajahi Profil Sekolah</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#schoolCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#schoolCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Berikutnya</span>
    </button>
</div>

<!-- FLOATING INFO CARDS -->
<div class="container info-cards">
    <div class="row g-4">
        <div class="col-lg-3 col-md-6 reveal-segment" data-aos="fade-up" data-aos-delay="100">
            <div class="info-card-item text-center">
                <div class="info-icon-wrapper"><i class="fas fa-school"></i></div>
                <h4 class="fw-bold mb-2">Identitas Sekolah</h4>
                <p class="text-muted small mb-3">Mengenal sejarah, visi, misi, dan struktur organisasi sekolah.</p>
                <a href="{{ route('profil') }}" class="btn btn-link text-decoration-none fw-bold p-0" style="color:var(--accent);">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 reveal-segment" data-aos="fade-up" data-aos-delay="200">
            <div class="info-card-item text-center">
                <div class="info-icon-wrapper"><i class="fas fa-user-tie"></i></div>
                <h4 class="fw-bold mb-2">Guru &amp; GTK</h4>
                <p class="text-muted small mb-3">Daftar lengkap pendidik dan tenaga kependidikan profesional.</p>
                <a href="{{ route('guru') }}" class="btn btn-link text-decoration-none fw-bold p-0" style="color:var(--accent);">Lihat Data <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 reveal-segment" data-aos="fade-up" data-aos-delay="300">
            <div class="info-card-item text-center">
                <div class="info-icon-wrapper"><i class="fas fa-graduation-cap"></i></div>
                <h4 class="fw-bold mb-2">PPDB Online</h4>
                <p class="text-muted small mb-3">Informasi pendaftaran siswa baru, syarat, dan alur seleksi.</p>
                <a href="{{ route('ppdb') }}" class="btn btn-link text-decoration-none fw-bold p-0" style="color:var(--accent);">Daftar Sekarang <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 reveal-segment" data-aos="fade-up" data-aos-delay="400">
            <div class="info-card-item text-center">
                <div class="info-icon-wrapper"><i class="fas fa-bullhorn"></i></div>
                <h4 class="fw-bold mb-2">Pengumuman</h4>
                <p class="text-muted small mb-3">
                    {{ $latestPengumuman ? Str::limit(strip_tags($latestPengumuman->judul), 75) : 'Belum ada pengumuman terbaru saat ini.' }}
                </p>
                <a href="{{ $latestPengumuman ? route('berita.detail', $latestPengumuman->slug) : route('informasi', ['kategori' => 'pengumuman']) }}" class="btn btn-link text-decoration-none fw-bold p-0" style="color:var(--accent);">
                    {{ $latestPengumuman ? 'Baca Pengumuman' : 'Lihat Pengumuman' }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@php
    $kepsekPlaceholder = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="400" height="500" viewBox="0 0 400 500">
    <rect width="400" height="500" fill="#f1f5f9"/>
    <circle cx="200" cy="180" r="90" fill="#bfdbfe"/>
    <rect x="90" y="310" width="220" height="130" rx="65" fill="#bfdbfe"/>
    <text x="200" y="470" font-size="28" text-anchor="middle" fill="#64748b">Kepala Sekolah</text>
</svg>
SVG;
    $fallbackKepsekSvg = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($kepsekPlaceholder);
    $kepsekPhoto = $profil?->foto_kepsek
        ? url('media/' . ltrim(preg_replace('/^(storage\/|media\/)+/', '', $profil->foto_kepsek), '/'))
        : $fallbackKepsekSvg;

    $teacherPlaceholder = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="400" height="460" viewBox="0 0 400 460">
    <rect width="400" height="460" fill="#f1f5f9"/>
    <circle cx="200" cy="150" r="90" fill="#cbd5e1"/>
    <path d="M70 360c0-72 58-130 130-130s130 58 130 130" fill="#cbd5e1"/>
    <rect x="70" y="340" width="260" height="90" rx="45" fill="#e2e8f0"/>
</svg>
SVG;
    $defaultTeacherPhoto = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($teacherPlaceholder);
@endphp

<!-- HIGHLIGHTS & INFORMASI UTAMA SEKOLAH -->
<section class="stats-section mt-5">
    <div class="container">
        <div class="row g-4 text-center justify-content-center">
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-award"></i></div>
                    <span class="stat-number" style="font-size: 1.65rem; letter-spacing: -0.01em;">AKREDITASI A</span>
                    <span class="stat-label">Predikat Unggul BAN-S/M</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <span class="stat-number"><span class="counter" data-target="{{ $stats['teachers'] ?? 52 }}">0</span><sup>+</sup></span>
                    <span class="stat-label">Guru &amp; Staf GTK</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-laptop-code"></i></div>
                    <span class="stat-number" style="font-size: 1.65rem; letter-spacing: -0.01em;">SMART SCHOOL</span>
                    <span class="stat-label">Layanan Serba Digital</span>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-leaf"></i></div>
                    <span class="stat-number" style="font-size: 1.65rem; letter-spacing: -0.01em;">ADIWIYATA</span>
                    <span class="stat-label">Wawasan Lingkungan</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SAMBUTAN KEPALA SEKOLAH -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-4 col-md-5">
                <div class="kepsek-frame">
                    <div class="ratio ratio-4x5" style="min-height: 380px;">
                        <img src="{{ $kepsekPhoto }}" class="w-100 h-100" style="object-fit: cover; object-position: top center;" alt="Kepala Sekolah" onerror="this.onerror=null; this.src='{{ asset('img/placeholder.jpg') }}';">
                    </div>
                    <div class="kepsek-badge-float">
                        <i class="fas fa-user-shield me-1"></i> Kepala Sekolah
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <span class="section-badge"><i class="fas fa-quote-left me-1"></i> Sambutan Kepala Sekolah</span>
                <h2 class="section-title mb-3">{{ $profil?->kepala_sekolah ?? 'Kepala Sekolah SMPN 4 Samarinda' }}</h2>
                <div class="sambutan-quote mb-4">
                    <p class="text-muted lh-lg fs-6 mb-0">{{ Str::limit(strip_tags($profil?->sambutan_kepsek ?? 'Selamat datang di website resmi SMP Negeri 4 Samarinda. Kami berkomitmen memberikan pendidikan terbaik untuk generasi penerus bangsa.'), 450) }}</p>
                </div>
                <a href="{{ route('profil') }}" class="btn btn-primary-custom">
                    <span>Baca Sambutan Lengkap <i class="fas fa-arrow-right ms-2"></i></span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- GURU & GTK HIGHLIGHT -->
@if($featuredTeachers->isNotEmpty())
@php
    $shuffledTeachers = $featuredTeachers->shuffle();
    $gtkSlides = $shuffledTeachers->chunk(4);
    $teacherDataset = $featuredTeachers->map(function ($teacher) use ($defaultTeacherPhoto) {
        return [
            'nama' => $teacher->nama,
            'jabatan' => $teacher->jabatan ?? 'Tenaga Kependidikan',
            'nip' => $teacher->nip,
            'jenis' => $teacher->jenis ? strtoupper($teacher->jenis) : null,
            'foto' => $teacher->foto
                ? url('media/' . ltrim(preg_replace('/^(storage\/|media\/)+/', '', $teacher->foto), '/'))
                : $defaultTeacherPhoto,
        ];
    });
@endphp
<section class="py-5 gtk-highlight" id="gtk-highlight">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4" data-aos="fade-up">
            <div>
                <span class="section-badge"><i class="fas fa-users me-1"></i> Pendidik &amp; Tenaga Kependidikan</span>
                <h2 class="section-title mb-0">Guru &amp; Staf Terbaik</h2>
            </div>
            <a href="{{ route('guru') }}" class="btn btn-primary-custom"><span>Lihat Semua GTK <i class="fas fa-arrow-right ms-1"></i></span></a>
        </div>

        <div id="gtkCarousel" class="carousel slide gtk-carousel" data-bs-ride="carousel" data-bs-interval="4800" data-bs-touch="true">
            <div class="carousel-inner">
                @foreach($gtkSlides as $slide)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach($slide as $teacher)
                                @php
                                    $photoUrl = $teacher->foto
                                        ? url('media/' . ltrim(preg_replace('/^(storage\/|media\/)+/', '', $teacher->foto), '/'))
                                        : $defaultTeacherPhoto;
                                @endphp
                                <div class="col-sm-6 col-lg-3">
                                    <div class="gtk-card text-center h-100">
                                        <div class="gtk-photo mb-3">
                                            <img src="{{ $photoUrl }}" alt="{{ $teacher->nama }}" loading="lazy" onerror="this.onerror=null; this.src='{{ $defaultTeacherPhoto }}';">
                                        </div>
                                        <h5 class="fw-bold mb-1 fs-6">{{ $teacher->nama }}</h5>
                                        <p class="text-muted small mb-2">{{ $teacher->jabatan ?? 'Tenaga Kependidikan' }}</p>
                                        @if($teacher->nip)
                                            <p class="text-muted small mb-2" style="font-size:0.75rem;">NIP: {{ $teacher->nip }}</p>
                                        @endif
                                        @if($teacher->jenis)
                                            <span class="badge" style="background:var(--gold-light); color:var(--gold-dark); font-weight:700;">{{ Str::upper($teacher->jenis) }}</span>
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
@endif

<!-- BERITA & INFORMASI TERKINI -->
<section class="py-5" id="berita">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4" data-aos="fade-up">
            <div>
                <span class="section-badge"><i class="fas fa-newspaper me-1"></i> Kabar Sekolah</span>
                <h2 class="section-title mb-0">Berita &amp; Informasi Terkini</h2>
            </div>
            <a href="{{ route('informasi') }}" class="btn btn-primary-custom"><span>Lihat Semua Informasi <i class="fas fa-arrow-right ms-1"></i></span></a>
        </div>

        <div class="row g-4">
            {{-- Main News List --}}
            <div class="col-lg-8" data-aos="fade-right">
                <div class="row g-4">
                    @foreach($berita as $post)
                    <div class="col-md-6">
                        <div class="news-card">
                            <div class="news-card__img-wrap">
                                <img src="{{ $post->gambar_url }}" class="news-card__img" alt="{{ $post->judul }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('img/placeholder.jpg') }}';">
                            </div>
                            <div class="news-card__body">
                                <span class="news-card__cat">{{ ucfirst($post->kategori ?? 'Berita') }}</span>
                                <a href="{{ route('berita.detail', $post->slug) }}" class="news-card__title">{{ Str::limit($post->judul, 55) }}</a>
                                <p class="text-muted small mt-2 mb-0" style="font-size:0.82rem; line-height:1.5;">{{ Str::limit(strip_tags($post->isi), 85) }}</p>
                                <div class="news-card__meta d-flex justify-content-between align-items-center">
                                    <span><i class="far fa-calendar-alt me-1"></i> {{ $post->created_at->format('d M Y') }}</span>
                                    <a href="{{ route('berita.detail', $post->slug) }}" class="text-decoration-none fw-semibold" style="color:var(--accent); font-size:0.8rem;">Baca <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Sidebar Pengumuman & Agenda --}}
            <div class="col-lg-4" data-aos="fade-left">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                    <div id="pengumuman" class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width:32px;height:32px;border-radius:8px;background:var(--gold-light);color:var(--gold-dark);display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-bullhorn" style="font-size:0.9rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Pengumuman</h5>
                        </div>
                        <ul class="announce-list">
                            @forelse($pengumuman as $info)
                            <li class="announce-item">
                                <div class="announce-dot"></div>
                                <div>
                                    <a href="{{ route('berita.detail', $info->slug) }}" class="announce-title">{{ $info->judul }}</a>
                                    <div class="announce-date mt-1"><i class="far fa-clock me-1"></i> {{ $info->created_at->format('d M Y') }}</div>
                                </div>
                            </li>
                            @empty
                            <li class="text-muted small py-2">Belum ada pengumuman baru.</li>
                            @endforelse
                        </ul>
                    </div>

                    <hr class="my-3">

                    <div id="agenda">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width:32px;height:32px;border-radius:8px;background:var(--accent-light);color:var(--accent);display:flex;align-items:center;justify-content:center;">
                                <i class="far fa-calendar-check" style="font-size:0.9rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Agenda Kegiatan</h5>
                        </div>
                        <ul class="announce-list">
                            @forelse($agenda as $ag)
                            <li class="announce-item">
                                <div class="announce-dot" style="background:var(--accent);"></div>
                                <div>
                                    <a href="{{ route('berita.detail', $ag->slug) }}" class="announce-title">{{ $ag->judul }}</a>
                                    <div class="announce-date mt-1"><i class="far fa-calendar me-1"></i> {{ $ag->created_at->format('d M Y') }}</div>
                                </div>
                            </li>
                            @empty
                            <li class="text-muted small py-2">Belum ada agenda kegiatan mendatang.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GALERI FOTO & VIDEO TERBARU -->
<section class="py-5 bg-white border-top" id="galeri-terbaru">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4" data-aos="fade-up">
            <div>
                <span class="section-badge"><i class="fas fa-photo-video me-1"></i> Dokumentasi</span>
                <h2 class="section-title mb-0">Galeri Foto &amp; Video</h2>
            </div>
            <a href="{{ route('galeri') }}" class="btn btn-primary-custom"><span>Lihat Semua Galeri <i class="fas fa-arrow-right ms-1"></i></span></a>
        </div>

        <div class="row g-4">
            {{-- Video Section --}}
            <div class="col-lg-6" data-aos="fade-right">
                <div class="bg-light p-4 rounded-4 border h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="fab fa-youtube text-danger me-2"></i>Video Terbaru</h5>
                        <span class="badge" style="background:var(--accent-light); color:var(--accent);">{{ $latestVideos->count() }} Video</span>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @forelse($latestVideos as $video)
                        <div class="gallery-video-card bg-white">
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $video->embed_url }}" title="{{ $video->judul }}" allowfullscreen loading="lazy"></iframe>
                            </div>
                            <div class="p-3">
                                <h6 class="fw-bold mb-1 fs-6">{{ $video->judul }}</h6>
                                <p class="text-muted small mb-2" style="font-size:0.8rem;">{{ Str::limit($video->deskripsi, 80) }}</p>
                                <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-danger" style="font-size:0.78rem;">
                                    <i class="fab fa-youtube me-1"></i> Buka di YouTube
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted mb-0">Belum ada video yang diunggah.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Photo Section --}}
            <div class="col-lg-6" data-aos="fade-left">
                <div class="bg-light p-4 rounded-4 border h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="fas fa-camera text-primary me-2"></i>Foto Aktivitas</h5>
                        <span class="badge" style="background:var(--gold-light); color:var(--gold-dark);">{{ $latestPhotos->count() }} Foto</span>
                    </div>
                    <div class="gallery-grid">
                        @forelse($latestPhotos as $photo)
                        @php $photoUrl = $photo->image_url; @endphp
                        <div class="gallery-item gallery-photo-trigger"
                            data-photo="{{ $photoUrl }}"
                            data-title="{{ $photo->judul }}"
                            tabindex="0"
                            role="button">
                            <img src="{{ $photoUrl }}" alt="{{ $photo->judul }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('img/placeholder.jpg') }}';">
                            <div class="gallery-overlay-icon"><i class="fas fa-search-plus"></i></div>
                            <div class="gallery-overlay">
                                <span class="small fw-semibold text-truncate">{{ $photo->judul }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted mb-0">Belum ada foto terbaru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Photo Preview Modal -->
<div class="modal fade" id="photoPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="photoPreviewTitle">Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="photoPreviewImage" src="" alt="Foto" class="img-fluid rounded-3 shadow" onerror="this.onerror=null; this.src='{{ asset('img/placeholder.jpg') }}';">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Stat Counter animation with GSAP or Vanilla JS Fallback
    const counters = document.querySelectorAll('.counter');
    if (counters.length) {
        const animateCounters = () => {
            counters.forEach((counter) => {
                const target = parseInt(counter.getAttribute('data-target'), 10) || 0;
                let count = 0;
                const speed = Math.ceil(target / 60);

                const updateCount = () => {
                    count += speed;
                    if (count >= target) {
                        counter.textContent = target;
                    } else {
                        counter.textContent = count;
                        requestAnimationFrame(updateCount);
                    }
                };
                updateCount();
            });
        };

        if ('IntersectionObserver' in window) {
            const statsSection = document.querySelector('.stats-section');
            if (statsSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            animateCounters();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.3 });
                observer.observe(statsSection);
            }
        } else {
            animateCounters();
        }
    }

    // Photo Preview Modal Listener
    const modalElement = document.getElementById('photoPreviewModal');
    if (modalElement && typeof bootstrap !== 'undefined') {
        const modalInstance = new bootstrap.Modal(modalElement);
        const titleElement = document.getElementById('photoPreviewTitle');
        const imageElement = document.getElementById('photoPreviewImage');

        const showPreview = (trigger) => {
            const photo = trigger.getAttribute('data-photo');
            const title = trigger.getAttribute('data-title') || 'Foto';

            if (!photo || !imageElement || !titleElement) {
                return;
            }

            imageElement.src = photo;
            imageElement.alt = title;
            titleElement.textContent = title;
            modalInstance.show();
        };

        document.querySelectorAll('.gallery-photo-trigger').forEach((trigger) => {
            trigger.addEventListener('click', () => showPreview(trigger));
            trigger.addEventListener('keypress', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    showPreview(trigger);
                }
            });
        });
    }
});
</script>
@endpush
