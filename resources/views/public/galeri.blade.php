@extends('layouts.app')

@push('styles')
<style>
    #galleryTab .nav-link {
        border: 1px solid #0d6efd;
        color: #0d6efd;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 999px;
        background-color: #fff;
        box-shadow: 0 0.3rem 1rem rgba(13, 110, 253, 0.12);
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    #galleryTab .nav-link i {
        margin-right: 0.4rem;
    }

    #galleryTab .nav-link.active,
    #galleryTab .nav-link:hover {
        color: #fff;
        background-color: #0d6efd;
        box-shadow: 0 0.45rem 1.4rem rgba(13, 110, 253, 0.25);
    }

    #galleryTab .nav-link:not(.active):hover {
        color: #0d6efd;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Galeri Sekolah</h1>
        <p class="text-muted">Jelajahi dokumentasi kegiatan SMPN 4 Samarinda melalui koleksi video dan foto.</p>
    </div>

    <ul class="nav nav-pills justify-content-center mb-4" id="galleryTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="video-tab" data-bs-toggle="pill" data-bs-target="#tab-video" type="button" role="tab" aria-controls="tab-video" aria-selected="true">
                <i class="fas fa-video me-2"></i>Video
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="photo-tab" data-bs-toggle="pill" data-bs-target="#tab-photo" type="button" role="tab" aria-controls="tab-photo" aria-selected="false">
                <i class="fas fa-camera me-2"></i>Foto
            </button>
        </li>
    </ul>

    <div class="tab-content" id="galleryTabContent">
        <div class="tab-pane fade show active" id="tab-video" role="tabpanel" aria-labelledby="video-tab">
            <div class="row g-4">
                @forelse($videos as $video)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $video->embed_url }}" title="{{ $video->judul }}" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $video->judul }}</h5>
                            <p class="text-muted small">{{ \Illuminate\Support\Str::limit($video->deskripsi, 100) }}</p>
                            <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-success">Buka di YouTube</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">Belum ada koleksi video. Silakan kembali lagi nanti.</div>
                </div>
                @endforelse
            </div>
        </div>
        <div class="tab-pane fade" id="tab-photo" role="tabpanel" aria-labelledby="photo-tab">
            <div class="row g-4 mt-1">
                @forelse($galleries as $item)
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" style="height:220px; object-fit:cover" alt="{{ $item->judul }}">
                        <div class="card-body">
                            <h6 class="fw-bold">{{ $item->judul }}</h6>
                            <p class="text-muted small">{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">Belum ada foto pada galeri.</div>
                </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
