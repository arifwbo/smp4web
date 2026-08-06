@extends('layouts.app')

@section('content')
@php
    $filterTabs = collect(['semua' => ['label' => 'Semua Fasilitas', 'icon' => 'fa-border-all', 'description' => 'Seluruh data sarana & prasarana']])
        ->merge($categoryMeta);
@endphp

<section class="sarpras-hero position-relative overflow-hidden">
    <div class="sarpras-hero__bg"></div>
    <div class="container position-relative py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <p class="text-uppercase text-warning mb-2 fw-semibold reveal-segment">Sarana & Prasarana SMP Negeri 4 Samarinda</p>
                <h1 class="display-5 fw-bold text-white mb-3 reveal-segment" data-reveal="left">Fasilitas lengkap untuk mendukung pembelajaran aktif & karakter.</h1>
                <p class="text-white-50 lead mb-4 reveal-segment" data-reveal="left">
                    Data ini menampilkan kondisi terbaru ruang kelas, laboratorium, kawasan hijau, hingga fasilitas penunjang
                    yang siap digunakan oleh warga sekolah.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('kontak') }}" class="btn btn-warning text-dark fw-semibold px-4 shadow-sm reveal-segment">Konsultasi Sarpras</a>
                    <a href="{{ route('profil') }}" class="btn btn-outline-light fw-semibold px-4 reveal-segment" data-reveal="right">
                        Profil Sekolah <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="sarpras-highlight reveal-segment" data-reveal="right">
                    <h5 class="text-uppercase text-white-50 mb-3">Ringkasan Kondisi</h5>
                    <ul class="list-unstyled mb-0 text-white">
                        <li class="d-flex align-items-start mb-3">
                            <div class="icon-circle-soft me-3 bg-white text-primary"><i class="fas fa-school"></i></div>
                            <div>
                                <div class="fw-semibold text-white">{{ $categoryCounts['semua'] ?? 0 }} fasilitas aktif</div>
                                <small class="text-white-50">Terdeploy di seluruh area sekolah.</small>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <div class="icon-circle-soft me-3 bg-white text-primary"><i class="fas fa-leaf"></i></div>
                            <div>
                                <div class="fw-semibold text-white">{{ $conditionStats['baik'] ?? 0 }} unit layak pakai</div>
                                <small class="text-white-50">Rutin dilakukan perawatan preventif.</small>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <div class="icon-circle-soft me-3 bg-white text-primary"><i class="fas fa-hammer"></i></div>
                            <div>
                                <div class="fw-semibold text-white">{{ $conditionStats['perlu_perbaikan'] ?? 0 }} agenda perbaikan</div>
                                <small class="text-white-50">Termasuk lapangan & ruang penunjang.</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sarpras-stats container py-5">
    <div class="row g-4">
        <div class="col-md-4 reveal-segment">
            <div class="sarpras-stat-card">
                <span class="sarpras-stat-label">Total Fasilitas</span>
                <h3>{{ number_format($categoryCounts['semua'] ?? 0) }} Unit</h3>
                <p>Sudah dipetakan ke dalam 5 kategori utama.</p>
            </div>
        </div>
        <div class="col-md-4 reveal-segment" data-reveal="left">
            <div class="sarpras-stat-card">
                <span class="sarpras-stat-label">Terdokumentasi</span>
                <h3>{{ number_format($galleryFacilities->count()) }} Foto</h3>
                <p>Foto terbaru untuk publikasi dan monitoring.</p>
            </div>
        </div>
        <div class="col-md-4 reveal-segment" data-reveal="right">
            <div class="sarpras-stat-card">
                <span class="sarpras-stat-label">Perlu Perhatian</span>
                <h3>{{ number_format($conditionStats['perlu_perbaikan'] ?? 0) }} Unit</h3>
                <p>Masuk rencana perbaikan semester berjalan.</p>
            </div>
        </div>
    </div>
</section>

<section class="container pb-4">
    <div class="sarpras-filter shadow-sm">
        @foreach($filterTabs as $key => $meta)
            @php
                $isActive = $activeCategory === $key;
                $label = $meta['label'] ?? $meta['description'] ?? ucfirst($key);
                $count = $categoryCounts[$key] ?? 0;
                $url = $key === 'semua' ? route('sarpras') : route('sarpras', ['kategori' => $key]);
            @endphp
            <a href="{{ $url }}" class="sarpras-filter__item {{ $isActive ? 'is-active' : '' }}">
                <div class="sarpras-filter__icon">
                    <i class="fa-solid {{ $meta['icon'] ?? 'fa-layer-group' }}"></i>
                </div>
                <div>
                    <div class="fw-semibold">{{ $key === 'semua' ? 'Semua Fasilitas' : $label }}</div>
                    <small class="text-muted">{{ $count }} data</small>
                </div>
            </a>
        @endforeach
    </div>
</section>

<section class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="section-title text-primary mb-1">{{ $activeCategory === 'semua' ? 'Pemetaan Seluruh Sarpras' : ($filterTabs[$activeCategory]['label'] ?? 'Data Sarpras') }}</h2>
            <p class="text-muted mb-0">Ditampilkan menurut kategori dan kondisi pemeliharaan.</p>
        </div>
        <a href="{{ route('sarpras') }}" class="btn btn-outline-primary btn-sm">Reset Filter</a>
    </div>

    <div class="row g-4">
        @forelse($facilities as $facility)
            @php
                $condition = $conditionMeta[$facility->kondisi] ?? ['label' => 'N/A', 'badge' => 'secondary'];
                $category = $categoryMeta[$facility->kategori] ?? ['label' => 'Fasilitas'];
            @endphp
            <div class="col-xl-4 col-md-6 reveal-segment" data-reveal="{{ $loop->iteration % 2 === 0 ? 'left' : 'right' }}">
                <div class="sarpras-card h-100">
                    <div class="sarpras-card__media {{ $facility->photo_url ? '' : 'is-placeholder' }}" @if($facility->photo_url) style="background-image:url('{{ $facility->photo_url }}');" @endif>
                        <span class="sarpras-card__category">
                            <i class="fa-solid {{ $category['icon'] ?? 'fa-circle' }} me-1"></i>
                            {{ $category['label'] ?? 'Fasilitas' }}
                        </span>
                    </div>
                    <div class="sarpras-card__body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-semibold text-primary mb-0">{{ $facility->nama }}</h5>
                            <span class="badge bg-{{ $condition['badge'] ?? 'secondary' }}">{{ $condition['label'] }}</span>
                        </div>
                        <p class="text-muted mb-3">{{ \Illuminate\Support\Str::limit($facility->deskripsi, 140) }}</p>
                        <ul class="list-unstyled sarpras-card__meta">
                            <li><i class="fas fa-layer-group me-2 text-primary"></i>Jumlah unit: <strong>{{ $facility->jumlah ?? '-' }}</strong></li>
                            <li><i class="fas fa-calendar-check me-2 text-success"></i>Pembaruan: {{ optional($facility->updated_at)->translatedFormat('d M Y') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="sarpras-empty text-center p-5">
                    <i class="fas fa-dolly-flatbed fa-2x text-warning mb-3"></i>
                    <h5 class="fw-semibold mb-2">Belum ada data pada kategori ini.</h5>
                    <p class="text-muted mb-3">Silakan pilih kategori lain atau hubungi tim sarana prasarana apabila membutuhkan data tambahan.</p>
                    <a href="{{ route('sarpras') }}" class="btn btn-primary-custom">Kembali ke semua data</a>
                </div>
            </div>
        @endforelse
    </div>
</section>

@if($recentSnapshots->isNotEmpty())
<section class="container pb-5">
    <div class="row g-4 align-items-center">
        <div class="col-lg-5">
            <h3 class="fw-bold text-primary mb-3">Catatan singkat pemeliharaan terbaru</h3>
            <p class="text-muted mb-4">
                Update ini membantu orang tua maupun komite sekolah memantau progres perbaikan dan pengadaan fasilitas secara berkala.
            </p>
            <a href="{{ route('kontak') }}" class="btn btn-outline-primary">Koordinasi dengan tim Sarpras</a>
        </div>
        <div class="col-lg-7">
            <div class="sarpras-timeline">
                @foreach($recentSnapshots as $snapshot)
                    @php
                        $condition = $conditionMeta[$snapshot->kondisi] ?? ['label' => 'N/A', 'badge' => 'secondary'];
                        $category = $categoryMeta[$snapshot->kategori] ?? ['label' => 'Fasilitas'];
                    @endphp
                    <div class="sarpras-timeline__item reveal-segment">
                        <div class="sarpras-timeline__badge bg-{{ $condition['badge'] ?? 'secondary' }}"></div>
                        <div>
                            <div class="small text-muted">{{ optional($snapshot->updated_at)->translatedFormat('d M Y') }} • {{ $category['label'] ?? '-' }}</div>
                            <h5 class="mb-1">{{ $snapshot->nama }}</h5>
                            <p class="mb-2 text-muted">{{ \Illuminate\Support\Str::limit($snapshot->deskripsi, 120) }}</p>
                            <span class="badge bg-light text-dark border">Kondisi: {{ $condition['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($galleryFacilities->isNotEmpty())
<section class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Galeri Foto Sarpras</h3>
            <p class="text-muted mb-0">Snapshot dokumentasi terbaru sebagai bahan laporan dan publikasi.</p>
        </div>
        <span class="badge bg-light text-dark border">{{ $galleryFacilities->count() }} foto ditampilkan</span>
    </div>
    <div class="sarpras-gallery">
        @foreach($galleryFacilities as $photo)
            <div class="sarpras-gallery__item reveal-segment" style="background-image:url('{{ $photo->photo_url }}');">
                <div class="sarpras-gallery__overlay">
                    <div class="fw-semibold">{{ $photo->nama }}</div>
                    <small>{{ $categoryMeta[$photo->kategori]['label'] ?? 'Sarpras' }}</small>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif
@endsection
