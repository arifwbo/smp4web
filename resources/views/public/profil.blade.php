@extends('layouts.app')
@section('content')
<div class="bg-primary-custom py-5 mb-5 text-white">
    <div class="container">
        <h1 class="fw-bold">Profil Sekolah</h1>
        <p class="lead mb-0">Mengenal Lebih Dekat SMP Negeri 4 Samarinda</p>
    </div>
</div>

<style>
    .profile-hero {
        background: linear-gradient(135deg, #003366 0%, #012a63 60%, #024c9c 100%);
        color: #fff;
    }
    .profile-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 20px 45px rgba(19, 41, 82, 0.08);
    }
    .profile-tabs .list-group-item {
        border: none;
        border-radius: 0.75rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .profile-tabs .list-group-item.active {
        background: #fbbf24;
        color: #1f2937;
        box-shadow: 0 6px 18px rgba(251, 191, 36, 0.35);
    }
    .profile-section-title {
        letter-spacing: 0.08em;
        font-size: 0.85rem;
        color: #94a3b8;
    }
    .profile-content-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
    }
</style>

@php
    use Illuminate\Support\Str;
    $formerPrincipals = $formerPrincipals ?? collect();
@endphp

<div class="container pb-5">
        @php
            $logoCardPlaceholder = <<<SVG
    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
        <rect width="200" height="200" rx="40" fill="#f1f5f9"/>
        <text x="100" y="110" font-size="28" text-anchor="middle" fill="#94a3b8">Logo</text>
    </svg>
    SVG;
            $logoPublic = $profil?->logo_path
                ? asset('storage/' . $profil->logo_path)
                : 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($logoCardPlaceholder);
        @endphp

        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center gap-3 profile-card px-4 py-3">
                <img src="{{ $logoPublic }}" alt="Logo {{ $profil?->nama_sekolah }}" style="width: 110px; height: 110px; object-fit: contain;">
                <div class="text-start">
                    <p class="profile-section-title mb-1">Identitas Resmi</p>
                    <h3 class="fw-bold text-primary-custom mb-0">{{ $profil?->nama_sekolah ?? 'SMP Negeri 4 Samarinda' }}</h3>
                    <span class="text-muted">{{ $profil?->alamat ?? 'Alamat belum diisi' }}</span>
                </div>
            </div>
        </div>

    @if($profil?->foto_kepsek || $profil?->sambutan_kepsek)
        @php
            $placeholderSvg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="420" height="420" viewBox="0 0 420 420">
    <rect width="420" height="420" fill="#f3f4f6"/>
    <circle cx="210" cy="150" r="90" fill="#dbeafe"/>
    <rect x="100" y="250" width="220" height="120" rx="60" fill="#dbeafe"/>
    <text x="210" y="390" font-size="30" text-anchor="middle" fill="#94a3b8">Kepala Sekolah</text>
</svg>
SVG;
            $kepsekPhoto = $profil?->foto_kepsek
                ? asset('storage/' . $profil->foto_kepsek)
                : 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($placeholderSvg);
        @endphp
        <div class="row align-items-center mb-5 profile-card p-4">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <div class="p-4">
                    <div class="rounded-circle shadow-lg mx-auto mb-3" style="width: 220px; height: 220px; overflow: hidden;">
                        <img src="{{ $kepsekPhoto }}" alt="Foto Kepala Sekolah" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                    <h5 class="fw-bold mb-1">{{ $profil?->kepala_sekolah ?? 'Kepala Sekolah' }}</h5>
                    <span class="text-uppercase text-muted small">Kepala Sekolah</span>
                </div>
            </div>
            <div class="col-md-8">
                <div class="ps-md-4">
                    <p class="profile-section-title">Sambutan Kepala Sekolah</p>
                    <h2 class="fw-bold mb-4 text-primary-custom">{{ $profil?->kepala_sekolah ?? 'Kepala Sekolah' }}</h2>
                    <div class="lh-lg text-secondary">
                        {!! $profil?->sambutan_kepsek ?? '<p>Belum ada sambutan kepala sekolah.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($formerPrincipals->isNotEmpty())
        <div class="profile-card p-4 mb-5" id="riwayat-kepsek">
            <p class="profile-section-title">Jejak Kepemimpinan</p>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <h3 class="fw-bold text-primary-custom mb-0">Kepala Sekolah Terdahulu</h3>
                <span class="badge bg-light text-dark">Total {{ $formerPrincipals->count() }} orang</span>
            </div>
            <div class="row g-4">
                @foreach($formerPrincipals as $former)
                    <div class="col-md-6">
                        <div class="d-flex gap-3 align-items-start p-3 rounded shadow-sm h-100" style="background:#f8fafc;">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle overflow-hidden" style="width:80px;height:80px;background:#e2e8f0;">
                                    <img src="{{ $former->photo_url }}" alt="{{ $former->name }}" class="w-100 h-100" style="object-fit:cover;">
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $former->name }}</h5>
                                <span class="badge bg-warning text-dark mb-2">{{ $former->period ?? 'Periode tidak tersedia' }}</span>
                                <p class="text-muted small mb-0">{{ Str::limit($former->description, 180, '...') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="profile-card p-3 profile-tabs sticky-top" style="top: 110px;">
                <p class="profile-section-title">Navigasi</p>
                <div class="list-group">
                    <a href="#identitas" class="list-group-item list-group-item-action active" data-bs-toggle="list">Identitas</a>
                    <a href="#sejarah" class="list-group-item list-group-item-action" data-bs-toggle="list">Sejarah</a>
                    <a href="#visi" class="list-group-item list-group-item-action" data-bs-toggle="list">Visi & Misi</a>
                    <a href="#struktur" class="list-group-item list-group-item-action" data-bs-toggle="list">Struktur</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="identitas">
                    <div class="card profile-content-card mb-4"><div class="card-body"><h3 class="text-primary-custom fw-bold border-bottom pb-2 mb-3">Identitas Sekolah</h3><table class="table"><tr><th width="30%">Nama Sekolah</th><td>{{ $profil?->nama_sekolah }}</td></tr><tr><th>NPSN</th><td>{{ $profil?->npsn ?? '-' }}</td></tr><tr><th>Alamat</th><td>{{ $profil?->alamat }}</td></tr></table></div></div>
                </div>
                <div class="tab-pane fade" id="sejarah">
                    <div class="card profile-content-card mb-4"><div class="card-body"><h3 class="text-primary-custom fw-bold border-bottom pb-2 mb-3">Sejarah</h3><div class="lh-lg">{!! $profil?->sejarah ?? '<p>-</p>' !!}</div></div></div>
                </div>
                <div class="tab-pane fade" id="visi">
                    <div class="card profile-content-card mb-4"><div class="card-body"><h3 class="text-primary-custom fw-bold border-bottom pb-2 mb-3">Visi & Misi</h3><div class="alert alert-info"><h5>Visi</h5>{!! $profil?->visi ?? '<p>-</p>' !!}</div><div class="mt-3"><h5>Misi</h5><div class="bg-light p-3 rounded">{!! $profil?->misi ?? '<p>-</p>' !!}</div></div></div></div>
                </div>
                <div class="tab-pane fade" id="struktur">
                    <div class="card profile-content-card mb-4">
                        <div class="card-body">
                            <h3 class="text-primary-custom fw-bold border-bottom pb-2 mb-3">Struktur Organisasi</h3>
                            @if($profil?->struktur_organisasi && Str::contains($profil->struktur_organisasi, ['<img', '<svg', '<iframe', 'http']))
                                <div class="text-center">
                                    @if(Str::contains($profil->struktur_organisasi, ['<img', '<svg', '<iframe']))
                                        <div class="structure-media-wrapper">
                                            {!! $profil->struktur_organisasi !!}
                                        </div>
                                    @else
                                        <img src="{{ $profil->struktur_organisasi }}" alt="Struktur Organisasi" class="img-fluid structure-media-image">
                                    @endif
                                </div>
                            @elseif($profil?->struktur_organisasi)
                                <div class="bg-light p-4 rounded">
                                    {!! $profil->struktur_organisasi !!}
                                </div>
                            @else
                                <p class="text-muted text-center py-5">Gambar struktur belum diunggah.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>document.addEventListener("DOMContentLoaded",function(){var t=[].slice.call(document.querySelectorAll(".list-group-item"));t.forEach(function(e){var n=new bootstrap.Tab(e);e.addEventListener("click",function(t){t.preventDefault(),n.show()})})});</script>
<style>
    .structure-media-wrapper {
        position: relative;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        border-radius: 1rem;
        background: #f8fafc;
        box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.05);
    }
    .structure-media-wrapper img,
    .structure-media-wrapper iframe,
    .structure-media-wrapper svg {
        width: 100% !important;
        height: auto !important;
        display: block;
        object-fit: contain;
    }
    .structure-media-image {
        max-height: 460px;
        width: 100%;
        object-fit: contain;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
        background: #fff;
        padding: 1rem;
    }
</style>
@endsection
