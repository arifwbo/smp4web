@extends('layouts.app')

@section('content')
<div class="profile-hero text-white py-5 mb-5">
    <div class="container">
        <p class="text-uppercase text-white-50 mb-2">Profil Sekolah</p>
        <h1 class="fw-bold display-5 mb-1">SMP Negeri 4 Samarinda</h1>
        <p class="lead mb-0">Mengenal lebih dekat identitas, sejarah, serta arah kebijakan sekolah.</p>
    </div>
</div>

@php
    use Illuminate\Support\Str;

    $formerPrincipals = $formerPrincipals ?? collect();

    $logoCardPlaceholder = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="220" height="220" viewBox="0 0 220 220">
    <rect width="220" height="220" rx="48" fill="#f1f5f9"/>
    <text x="110" y="118" font-size="28" text-anchor="middle" fill="#94a3b8">Logo</text>
</svg>
SVG;

    $logoPublic = $profil?->logo_path
        ? asset('storage/' . $profil->logo_path)
        : 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($logoCardPlaceholder);

    $identityFacts = collect([
        ['label' => 'NPSN', 'value' => $profil?->npsn],
        ['label' => 'Akreditasi', 'value' => $profil?->akreditasi],
        ['label' => 'Telepon', 'value' => $profil?->telepon],
        ['label' => 'Email', 'value' => $profil?->email],
    ])->map(fn ($fact) => [
        'label' => $fact['label'],
        'value' => filled($fact['value']) ? $fact['value'] : 'Belum diisi',
    ]);

    $contactInfo = collect([
        ['icon' => 'fas fa-envelope', 'label' => 'Email', 'value' => $profil?->email, 'url' => filled($profil?->email) ? 'mailto:' . $profil->email : null],
        ['icon' => 'fas fa-phone', 'label' => 'Telepon', 'value' => $profil?->telepon],
        ['icon' => 'fab fa-whatsapp', 'label' => 'WhatsApp', 'value' => $profil?->whatsapp_number, 'url' => filled($profil?->whatsapp_number) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $profil->whatsapp_number) : null],
        ['icon' => 'fas fa-globe', 'label' => 'Website', 'value' => config('app.url'), 'url' => url('/')],
    ])->filter(fn ($item) => filled($item['value']))->values();

    $structureField = $profil?->struktur_organisasi;
    $hasStructureText = filled($structureField);
    $structureFieldIsEmbed = $hasStructureText && Str::contains($structureField, ['<img', '<svg', '<iframe']);

    $guruStructureImage = filled($profil?->struktur_guru_image)
        ? asset('storage/' . $profil->struktur_guru_image)
        : null;
    $tuStructureImage = filled($profil?->struktur_tu_image)
        ? asset('storage/' . $profil->struktur_tu_image)
        : null;

    $hasStructureImages = filled($guruStructureImage) || filled($tuStructureImage);
    $hasStructureMedia = $hasStructureText || $hasStructureImages;

    $mapsEmbedHtml = null;
    if (filled($profil?->maps_embed)) {
        $mapsEmbedHtml = $profil->maps_embed;
        if (Str::contains($mapsEmbedHtml, '](')) {
            $mapsEmbedHtml = preg_replace('/\[(https?:\/\/[^\]]+)\]\((https?:\/\/[^\)]+)\)/', '$2', $mapsEmbedHtml);
        }
    }
@endphp

<div class="container pb-5 profile-page">
    <div class="profile-card profile-identity-card p-4 p-lg-5 mb-5">
        <div class="row align-items-center g-4">
            <div class="col-md-4 text-center">
                <div class="identity-logo-frame mx-auto">
                    <img src="{{ $logoPublic }}" alt="Logo {{ $profil?->nama_sekolah ?? 'SMP Negeri 4 Samarinda' }}" class="img-fluid">
                </div>
            </div>
            <div class="col-md-8">
                <p class="profile-section-title mb-1">Identitas Resmi</p>
                <h2 class="fw-bold text-primary-custom mb-2">{{ $profil?->nama_sekolah ?? 'SMP Negeri 4 Samarinda' }}</h2>
                <p class="text-secondary mb-4">{{ $profil?->alamat ?? 'Alamat belum diisi' }}</p>
                <div class="identity-meta-grid">
                    @foreach($identityFacts as $fact)
                        <div class="identity-meta-tile">
                            <span class="meta-label">{{ $fact['label'] }}</span>
                            <strong class="meta-value">{{ $fact['value'] }}</strong>
                        </div>
                    @endforeach
                </div>
                @if($contactInfo->isNotEmpty())
                    <div class="contact-pill-group mt-3">
                        @foreach($contactInfo as $contact)
                            @if(isset($contact['url']))
                                <a href="{{ $contact['url'] }}" target="_blank" rel="noopener" class="contact-pill">
                                    <i class="{{ $contact['icon'] }}"></i>
                                    <span>{{ $contact['value'] }}</span>
                                </a>
                            @else
                                <span class="contact-pill">
                                    <i class="{{ $contact['icon'] }}"></i>
                                    <span>{{ $contact['value'] }}</span>
                                </span>
                            @endif
                        @endforeach
                    </div>
                @endif
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
        <div class="profile-card p-4 p-lg-5 mb-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-4 text-center">
                    <div class="kepsek-photo-frame mx-auto mb-3">
                        <img src="{{ $kepsekPhoto }}" alt="Foto Kepala Sekolah" class="w-100 h-100">
                    </div>
                    <h5 class="fw-bold mb-1">{{ $profil?->kepala_sekolah ?? 'Kepala Sekolah' }}</h5>
                    <span class="text-uppercase text-muted small">Kepala Sekolah</span>
                </div>
                <div class="col-lg-8">
                    <p class="profile-section-title">Sambutan Kepala Sekolah</p>
                    <h3 class="fw-bold text-primary-custom mb-3">{{ $profil?->kepala_sekolah ?? 'Kepala Sekolah' }}</h3>
                    <div class="sambutan-copy">
                        {!! $profil?->sambutan_kepsek ?? '<p>Belum ada sambutan kepala sekolah.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($formerPrincipals->isNotEmpty())
        <div class="profile-card p-4 p-lg-5 mb-5" id="riwayat-kepsek">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <p class="profile-section-title mb-1">Jejak Kepemimpinan</p>
                    <h3 class="fw-bold text-primary-custom mb-0">Kepala Sekolah Terdahulu</h3>
                </div>
                <span class="badge badge-soft-dark">Total {{ $formerPrincipals->count() }} Orang</span>
            </div>
            <div class="row g-4">
                @foreach($formerPrincipals as $former)
                    <div class="col-md-6">
                        <div class="former-card h-100">
                            <div class="former-avatar">
                                <img src="{{ $former->photo_url }}" alt="{{ $former->name }}">
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $former->name }}</h5>
                                <span class="former-period">{{ $former->period ?? 'Periode tidak tersedia' }}</span>
                                <p class="text-muted small mb-0">{{ Str::limit($former->description, 180, '...') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="profile-card profile-tabs">
                <p class="profile-section-title">Navigasi</p>
                <div class="list-group profile-nav" role="tablist">
                    <a href="#identitas" class="list-group-item list-group-item-action active" data-bs-toggle="list" role="tab">
                        <span>Identitas</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="#sejarah" class="list-group-item list-group-item-action" data-bs-toggle="list" role="tab">
                        <span>Sejarah</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="#visi" class="list-group-item list-group-item-action" data-bs-toggle="list" role="tab">
                        <span>Visi, Misi & Tujuan</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="#struktur" class="list-group-item list-group-item-action" data-bs-toggle="list" role="tab">
                        <span>Struktur Organisasi</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="identitas" role="tabpanel">
                    <div class="card profile-content-card mb-4">
                        <div class="card-body">
                            <div class="card-heading">
                                <h3>Identitas Sekolah</h3>
                                <p>Data dasar yang dirujuk dalam seluruh layanan publik sekolah.</p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="28%">Nama Sekolah</th>
                                            <td>{{ $profil?->nama_sekolah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NPSN</th>
                                            <td>{{ $profil?->npsn ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $profil?->alamat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $profil?->email ?? 'Belum diisi' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $profil?->telepon ?? 'Belum diisi' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="sejarah" role="tabpanel">
                    <div class="card profile-content-card mb-4">
                        <div class="card-body">
                            <div class="card-heading">
                                <h3>Sejarah</h3>
                                <p>Perjalanan SMP Negeri 4 Samarinda dari masa ke masa.</p>
                            </div>
                            <div class="lh-lg">
                                {!! $profil?->sejarah ?? '<p>-</p>' !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="visi" role="tabpanel">
                    <div class="card profile-content-card mb-4">
                        <div class="card-body">
                            <div class="card-heading">
                                <h3>Visi, Misi & Tujuan</h3>
                                <p>Landasan perencanaan strategis sekolah.</p>
                            </div>
                            <div class="alert alert-info vision-box">
                                <h5>Visi</h5>
                                {!! $profil?->visi ?? '<p>-</p>' !!}
                            </div>
                            <div class="mt-4">
                                <h5>Misi</h5>
                                <div class="bg-light p-3 rounded mission-box">
                                    {!! $profil?->misi ?? '<p>-</p>' !!}
                                </div>
                            </div>
                            @if(filled($profil?->tujuan))
                                <div class="mt-4">
                                    <h5>Tujuan</h5>
                                    <div class="bg-white border rounded p-3 tujuan-box">
                                        {!! $profil->tujuan !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="struktur" role="tabpanel">
                    <div class="card profile-content-card mb-4">
                        <div class="card-body">
                            <div class="card-heading">
                                <h3>Struktur Organisasi</h3>
                                <p>Menggambarkan susunan organisasi dan koordinasi kerja.</p>
                            </div>
                            @if($hasStructureMedia)
                                @if($hasStructureText)
                                    @if($structureFieldIsEmbed)
                                        <div class="structure-media-wrapper">
                                            {!! $structureField !!}
                                        </div>
                                    @elseif(Str::contains($structureField, ['http://', 'https://']))
                                        <div class="structure-media-wrapper">
                                            <img src="{{ $structureField }}" alt="Struktur Organisasi" class="structure-media-image">
                                        </div>
                                    @else
                                        <div class="bg-light p-4 rounded">{!! $structureField !!}</div>
                                    @endif
                                @endif

                                @if($hasStructureImages)
                                    <div class="row g-4 mt-1 structure-gallery">
                                        @if($guruStructureImage)
                                            <div class="col-md-6">
                                                <div class="structure-image-card h-100">
                                                    <div class="structure-image-frame">
                                                        <img src="{{ $guruStructureImage }}" alt="Struktur Organisasi Guru" loading="lazy">
                                                    </div>
                                                    <div class="structure-meta">
                                                        <div>
                                                            <h5 class="mb-1">Struktur Guru</h5>
                                                            <p class="text-muted small mb-0">Dokumen visual susunan guru dan penanggung jawab.</p>
                                                        </div>
                                                        <div class="structure-actions">
                                                            <a href="{{ $guruStructureImage }}" class="btn btn-sm btn-primary" target="_blank" rel="noopener">Lihat</a>
                                                            <a href="{{ $guruStructureImage }}" class="btn btn-sm btn-outline-secondary" download>
                                                                <i class="fas fa-download mr-1"></i>Unduh
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($tuStructureImage)
                                            <div class="col-md-6">
                                                <div class="structure-image-card h-100">
                                                    <div class="structure-image-frame">
                                                        <img src="{{ $tuStructureImage }}" alt="Struktur Organisasi Tata Usaha" loading="lazy">
                                                    </div>
                                                    <div class="structure-meta">
                                                        <div>
                                                            <h5 class="mb-1">Struktur Tata Usaha</h5>
                                                            <p class="text-muted small mb-0">Menampilkan koordinasi staf administrasi dan layanan TU.</p>
                                                        </div>
                                                        <div class="structure-actions">
                                                            <a href="{{ $tuStructureImage }}" class="btn btn-sm btn-primary" target="_blank" rel="noopener">Lihat</a>
                                                            <a href="{{ $tuStructureImage }}" class="btn btn-sm btn-outline-secondary" download>
                                                                <i class="fas fa-download mr-1"></i>Unduh
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <p class="text-muted text-center py-5">Gambar atau deskripsi struktur belum diunggah.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(filled($mapsEmbedHtml))
        <div class="profile-card p-4 p-lg-5 mt-4">
            <p class="profile-section-title mb-1">Lokasi Sekolah</p>
            <h3 class="fw-bold text-primary-custom mb-3">Peta SMP Negeri 4 Samarinda</h3>
            <div class="maps-embed-wrapper">
                {!! $mapsEmbedHtml !!}
            </div>
        </div>
    @else
        <div class="profile-card p-4 p-lg-5 mt-4 text-center text-muted">
            <p class="mb-0">Embed peta belum tersedia. Silakan perbarui tautan Google Maps melalui panel admin.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tabTriggers = [].slice.call(document.querySelectorAll('.profile-nav .list-group-item'));
    tabTriggers.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });
});
</script>
@endpush

@push('styles')
<style>
    .profile-hero {
        background: linear-gradient(135deg, #003366 0%, #012a63 60%, #024c9c 100%);
    }

    .profile-page {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .profile-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 20px 45px rgba(19, 41, 82, 0.08);
        position: relative;
        overflow: hidden;
    }

    .profile-section-title {
        letter-spacing: 0.08em;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #94a3b8;
    }

    .profile-content-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
    }

    .card-heading h3 {
        font-weight: 700;
        color: #012a63;
        margin-bottom: 0.25rem;
        width: 100%;
    }

    .card-heading p {
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .identity-logo-frame {
        width: 220px;
        height: 220px;
        border-radius: 2rem;
        opacity: 0.6;
        background: linear-gradient(145deg, #f8fafc 0%, #eef2ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.05);
        margin-bottom: 1rem;
    }

    .profile-tabs {
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        padding: 1.25rem;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        background: #fff;
    }

    @media (min-width: 992px) {
        .profile-tabs {
            position: sticky;
            top: 110px;
        }
    }

    .identity-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .profile-identity-card .row {
        align-items: center;
    }

    .identity-meta-tile {
        padding: 1rem;
        border-radius: 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .meta-label {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
    }

    .meta-value {
        font-size: 1.05rem;
        color: #0f172a;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    .contact-pill-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .contact-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        border: 1px solid #cbd5f5;
        color: #0f172a;
        font-size: 0.9rem;
        text-decoration: none;
        background: #fff;
    }

    .contact-pill i {
        color: #012a63;
    }

    .contact-pill span {
        overflow-wrap: anywhere;
        word-break: break-word;
        line-height: 1.2;
    }

    .kepsek-photo-frame {
        width: 220px;
        height: 220px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(1, 42, 99, 0.15);
        border: 6px solid #f8fafc;
    }

    .kepsek-photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sambutan-copy {
        color: #4b5563;
        line-height: 1.9;
    }

    .former-card {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
    }

    .former-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        background: #e2e8f0;
        flex-shrink: 0;
    }

    .former-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .former-period {
        display: inline-block;
        padding: 0.15rem 0.75rem;
        border-radius: 999px;
        background: rgba(251, 191, 36, 0.15);
        color: #92400e;
        font-size: 0.8rem;
        margin-bottom: 0.35rem;
    }

    .badge-soft-dark {
        background: rgba(15, 23, 42, 0.1);
        color: #0f172a;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        font-weight: 600;
    }

    .profile-tabs .list-group-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: none;
        border-radius: 0.85rem;
        margin-bottom: 0.6rem;
        font-weight: 600;
        color: #0f172a;
        padding: 0.85rem 1rem;
    }

    .profile-tabs .list-group-item.active {
        background: #fbbf24;
        color: #1f2937;
        box-shadow: 0 6px 18px rgba(251, 191, 36, 0.35);
    }

    .profile-tabs .list-group-item i {
        font-size: 0.85rem;
    }

    .vision-box h5,
    .mission-box h5,
    .profile-nav {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        width: 100%;
    }

    .tujuan-box h5 {
        font-weight: 600;
    }

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
        background: #fff;
    }

    .structure-gallery {
        margin-top: 1.5rem;
    }

    .structure-image-card {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.07);
    }

    .structure-image-frame {
        border-radius: 0.85rem;
        overflow: hidden;
        background: #000;
        max-height: 320px;
    }

    .structure-image-frame img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #0f172a;
    }

    .structure-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .structure-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .maps-embed-wrapper iframe {
        border: 0;
        width: 100% !important;
        min-height: 320px;
        border-radius: 1rem;
        box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.05);
    }

    @media (max-width: 991.98px) {
        .profile-identity-card .row {
            text-align: center;
        }

        .profile-identity-card .contact-pill-group {
            justify-content: center;
        }

        .identity-meta-grid {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .identity-logo-frame {
            width: 180px;
            height: 180px;
        }

        .profile-card {
            border-radius: 1rem;
        }

        .profile-tabs {
            position: static !important;
            margin-bottom: 1rem;
        }

        .profile-tabs .list-group-item {
            flex-direction: row;
        }
    }
</style>
@endpush
