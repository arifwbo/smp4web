@extends('layouts.app')

@section('content')
<section class="bg-light py-5 border-bottom">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="text-uppercase small text-primary fw-bold mb-2">Informasi Sekolah</p>
                <h1 class="fw-bold mb-3">Berita, Pengumuman, Agenda, dan Informasi Terbaru</h1>
                <p class="text-muted mb-0">Pantau kabar terbaru seputar SMP Negeri 4 Samarinda. Semua informasi penting kami rangkum pada satu halaman agar orang tua, siswa, dan masyarakat dapat mengakses perkembangan sekolah secara cepat.</p>
            </div>
            <div class="col-lg-5">
                <div class="bg-white rounded-4 shadow-sm p-4 border">
                    <h5 class="fw-semibold mb-3">Info Singkat</h5>
                    <ul class="list-unstyled mb-0 small text-muted">
                        <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Berita resmi dari sekolah</li>
                        <li class="mb-2"><i class="fa-solid fa-bell text-warning me-2"></i>Pengumuman penting untuk siswa dan orang tua</li>
                        <li class="mb-2"><i class="fa-solid fa-calendar-days text-primary me-2"></i>Agenda kegiatan sekolah</li>
                        <li><i class="fa-solid fa-circle-info text-info me-2"></i>Informasi umum dan publikasi lainnya</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @php
            $statCards = [
                'berita' => ['label' => 'Berita', 'icon' => 'fa-newspaper', 'caption' => 'Kabar terbaru sekolah', 'accent' => 'text-primary'],
                'informasi' => ['label' => 'Informasi', 'icon' => 'fa-circle-info', 'caption' => 'Rilis dan publikasi', 'accent' => 'text-info'],
                'pengumuman' => ['label' => 'Pengumuman', 'icon' => 'fa-bell', 'caption' => 'Pemberitahuan resmi', 'accent' => 'text-warning'],
                'agenda' => ['label' => 'Agenda', 'icon' => 'fa-calendar-days', 'caption' => 'Jadwal kegiatan', 'accent' => 'text-success'],
            ];
            $filterOptions = [
                'semua' => 'Semua Konten',
                'berita' => 'Berita',
                'informasi' => 'Informasi',
                'pengumuman' => 'Pengumuman',
                'agenda' => 'Agenda',
            ];
        @endphp

        <div class="row g-4 mb-4">
            @foreach($statCards as $key => $meta)
                <div class="col-6 col-lg-3">
                    <div class="border rounded-4 p-3 h-100 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-dark">{{ $meta['label'] }}</span>
                            <i class="fa-solid {{ $meta['icon'] }} {{ $meta['accent'] }}"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($categoryCounts[$key] ?? 0) }}</h3>
                        <small class="text-muted">{{ $meta['caption'] }}</small>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4">
            @foreach($filterOptions as $value => $label)
                @php
                    $isActive = $activeCategory === $value;
                    $link = $value === 'semua' ? route('informasi') : route('informasi', ['kategori' => $value]);
                @endphp
                <a href="{{ $link }}" class="btn btn-sm rounded-pill {{ $isActive ? 'btn-primary text-white shadow-sm' : 'btn-outline-secondary' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-16x9">
                            <img src="{{ $post->gambar_url }}" class="card-img-top rounded-top" alt="{{ $post->judul }}" style="object-fit: cover;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-light text-dark text-uppercase small mb-2">{{ ucfirst($post->kategori) }}</span>
                            <h5 class="card-title fw-bold mb-2">
                                <a href="{{ route('berita.detail', $post->slug) }}" class="text-decoration-none text-dark">{{ \Illuminate\Support\Str::limit($post->judul, 70) }}</a>
                            </h5>
                            <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit(strip_tags($post->isi), 140) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="fa-regular fa-clock me-1"></i>{{ optional($post->created_at)->format('d M Y') }}</small>
                                <a href="{{ route('berita.detail', $post->slug) }}" class="text-primary text-decoration-none fw-semibold">Baca<i class="fa-solid fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border rounded-4 shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-circle-info text-primary fs-3"></i>
                            <div>
                                <h5 class="mb-1">Belum ada konten pada kategori ini.</h5>
                                <p class="mb-0 text-muted">Silakan cek kategori lainnya atau kembali beberapa saat lagi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-uppercase small text-primary fw-bold mb-1">Sorotan Kategori</p>
                <h3 class="fw-bold mb-0">Ringkasan Cepat per Kategori</h3>
            </div>
            <span class="text-muted small">Memuat hingga 4 konten terbaru per kategori.</span>
        </div>
        <div class="row g-4">
            @foreach($groupedPosts as $category => $items)
                <div class="col-md-6 col-lg-3">
                    <div class="border rounded-4 h-100 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary-subtle text-primary text-uppercase small">{{ ucfirst($category) }}</span>
                            <a href="{{ route('informasi', ['kategori' => $category]) }}" class="small text-decoration-none text-muted">Lihat semua</a>
                        </div>
                        <ul class="list-unstyled mb-0 small">
                            @forelse($items as $item)
                                <li class="mb-3">
                                    <a href="{{ route('berita.detail', $item->slug) }}" class="fw-semibold text-decoration-none text-dark d-block">{{ \Illuminate\Support\Str::limit($item->judul, 50) }}</a>
                                    <span class="text-muted">{{ optional($item->created_at)->format('d M Y') }}</span>
                                </li>
                            @empty
                                <li class="text-muted">Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
