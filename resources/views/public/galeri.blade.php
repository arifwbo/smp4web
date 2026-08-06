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
@php
    $activeTab = request('tab', 'video');
@endphp
<div class="profile-hero py-5 mb-0">
    <div class="container">
        <p class="text-uppercase mb-2" style="color: rgba(255,255,255,0.75); letter-spacing: 0.12em; font-size: 0.8rem; font-weight: 600;">Dokumentasi</p>
        <h1 class="fw-bold display-5 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #ffffff; text-shadow: 0 2px 12px rgba(0,0,0,0.25); letter-spacing: -0.02em;">Galeri Sekolah</h1>
        <p class="lead mb-0" style="color: rgba(255,255,255,0.85); font-size: 1.05rem;">Jelajahi dokumentasi kegiatan SMPN 4 Samarinda melalui koleksi video dan foto.</p>
    </div>
</div>
<div class="container py-5">
    <ul class="nav nav-pills justify-content-center mb-4 reveal-segment" id="galleryTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'video' ? 'active' : '' }}" id="video-tab" data-bs-toggle="pill" data-bs-target="#tab-video" type="button" role="tab" aria-controls="tab-video" aria-selected="{{ $activeTab === 'video' ? 'true' : 'false' }}">
                <i class="fas fa-video me-2"></i>Video
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'photo' ? 'active' : '' }}" id="photo-tab" data-bs-toggle="pill" data-bs-target="#tab-photo" type="button" role="tab" aria-controls="tab-photo" aria-selected="{{ $activeTab === 'photo' ? 'true' : 'false' }}">
                <i class="fas fa-camera me-2"></i>Foto
            </button>
        </li>
    </ul>

    <div class="tab-content" id="galleryTabContent">
        <div class="tab-pane fade {{ $activeTab === 'video' ? 'show active' : '' }}" id="tab-video" role="tabpanel" aria-labelledby="video-tab">
            <div class="row g-4">
                @forelse($videos as $video)
                <div class="col-md-6 col-lg-4 reveal-segment">
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
                    <div class="alert alert-info text-center reveal-segment">Belum ada koleksi video. Silakan kembali lagi nanti.</div>
                </div>
                @endforelse
            </div>
        </div>
        <div class="tab-pane fade {{ $activeTab === 'photo' ? 'show active' : '' }}" id="tab-photo" role="tabpanel" aria-labelledby="photo-tab">
            <div class="row g-4 mt-1">
                @forelse($galleries as $item)
                <div class="col-md-4 col-lg-3 reveal-segment">
                    <div class="card border-0 shadow-sm h-100">
                        @php $photoUrl = $item->image_url; @endphp
                        <div
                            class="position-relative gallery-photo-trigger"
                            role="button"
                            tabindex="0"
                            aria-label="Pratinjau {{ $item->judul }}"
                            data-photo="{{ $photoUrl }}"
                            data-title="{{ $item->judul }}"
                            data-description="{{ \Illuminate\Support\Str::limit($item->deskripsi, 120) }}"
                        >
                            <img src="{{ $photoUrl }}" class="card-img-top" style="height:220px; object-fit:cover" alt="{{ $item->judul }}" onerror="this.onerror=null; this.src='{{ asset('img/placeholder.jpg') }}';">
                            <span class="visually-hidden">Buka pratinjau foto</span>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-bold">{{ $item->judul }}</h6>
                            <p class="text-muted small">{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center reveal-segment">Belum ada foto pada galeri.</div>
                </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $galleries->appends(['tab' => $activeTab])->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Photo Preview Modal -->
<div class="modal fade" id="galleryPhotoPreview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryPhotoTitle">Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <img id="galleryPhotoImage" src="" alt="Foto" class="img-fluid rounded shadow mb-3">
                <p id="galleryPhotoDescription" class="text-muted small mb-0"></p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalElement = document.getElementById('galleryPhotoPreview');
    const tabButtons = document.querySelectorAll('#galleryTab [data-bs-toggle="pill"]');
    const titleElement = document.getElementById('galleryPhotoTitle');
    const imageElement = document.getElementById('galleryPhotoImage');
    const descriptionElement = document.getElementById('galleryPhotoDescription');

    const updatePaginationLinks = (tab) => {
        document.querySelectorAll('.pagination a').forEach((link) => {
            const url = new URL(link.href, window.location.origin);
            url.searchParams.set('tab', tab);
            link.href = url.pathname + url.search;
        });
    };

    const params = new URLSearchParams(window.location.search);
    const initialTab = params.get('tab') || 'video';
    updatePaginationLinks(initialTab);

    tabButtons.forEach((button) => {
        button.addEventListener('shown.bs.tab', () => {
            const target = button.getAttribute('data-bs-target');
            const tab = target === '#tab-photo' ? 'photo' : 'video';
            const params = new URLSearchParams(window.location.search);
            params.set('tab', tab);
            params.delete('page');
            const query = params.toString();
            const newUrl = query ? `${window.location.pathname}?${query}` : window.location.pathname;
            window.history.replaceState({}, '', newUrl);
            updatePaginationLinks(tab);
        });
    });

    if (!modalElement || typeof bootstrap === 'undefined') {
        return;
    }

    const modalInstance = new bootstrap.Modal(modalElement);

    const openModal = (trigger) => {
        const photo = trigger.getAttribute('data-photo');
        const title = trigger.getAttribute('data-title') || 'Foto';
        const description = trigger.getAttribute('data-description') || '';

        if (!photo) {
            return;
        }

        if (imageElement) {
            imageElement.src = photo;
            imageElement.alt = title;
        }
        if (titleElement) {
            titleElement.textContent = title;
        }
        if (descriptionElement) {
            descriptionElement.textContent = description;
        }
        modalInstance.show();
    };

    document.querySelectorAll('[data-photo]').forEach((trigger) => {
        trigger.addEventListener('click', () => openModal(trigger));
        trigger.addEventListener('keypress', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openModal(trigger);
            }
        });
    });

    tabButtons.forEach((button) => {
        button.addEventListener('shown.bs.tab', () => {
            const target = button.getAttribute('data-bs-target');
            const tab = target === '#tab-photo' ? 'photo' : 'video';
            const params = new URLSearchParams(window.location.search);
            params.set('tab', tab);
            params.delete('page');
            const query = params.toString();
            const newUrl = query ? `${window.location.pathname}?${query}` : window.location.pathname;
            window.history.replaceState({}, '', newUrl);
        });
    });
});
</script>
@endpush

@endsection
