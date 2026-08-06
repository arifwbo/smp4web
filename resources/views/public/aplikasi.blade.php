@extends('layouts.app')

@push('styles')
<style>
    .app-hero {
        background: linear-gradient(135deg, #0a58ca 0%, #0d6efd 60%, #0a58ca 100%);
        color: #fff;
        padding: 4.5rem 0 3rem;
        position: relative;
        overflow: hidden;
    }
    .app-hero::after {
        content: '';
        position: absolute;
        inset: 15% 10% auto auto;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(255,193,7,0.25), transparent 70%);
        filter: blur(20px);
        pointer-events: none;
    }
    .app-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        background: rgba(255,255,255,0.15);
        font-size: 0.85rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .app-hero h1 {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-weight: 700;
        line-height: 1.2;
        color: #ffffff;
        text-shadow: 0 2px 16px rgba(0,0,0,0.25);
    }
    .app-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 0.75rem;
        margin-top: 2rem;
    }
    .app-metric-card {
        background: rgba(15,23,42,0.45);
        border: 1px solid rgba(148,163,184,0.25);
        border-radius: 1rem;
        padding: 1rem 1.1rem;
    }
    .app-metric-card span {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(226,232,240,0.75);
    }
    .app-metric-card strong {
        display: block;
        font-size: 1.8rem;
    }
    .app-featured {
        background: rgba(15,23,42,0.65);
        border: 1px solid rgba(148,163,184,0.3);
        border-radius: 1.5rem;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        min-height: 320px;
    }
    .app-featured::after {
        content: '';
        position: absolute;
        inset: 20px;
        border-radius: 1.25rem;
        border: 1px dashed rgba(148,163,184,0.35);
        pointer-events: none;
    }
    .app-featured img {
        border-radius: 1rem;
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        margin-bottom: 1rem;
        box-shadow: 0 20px 45px rgba(0,0,0,0.35);
    }
    .app-featured button,
    .app-featured a.btn {
        border-radius: 999px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
    }
    .app-grid-section {
        background: #f8fafc;
        position: relative;
        padding: 3.5rem 0 4rem;
    }
    .app-grid-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://www.transparenttextures.com/patterns/cubes.png');
        opacity: 0.07;
    }
    .app-card {
        position: relative;
        background: #fff;
        border-radius: 1.5rem;
        border: 1px solid rgba(15,23,42,0.08);
        box-shadow: 0 15px 35px rgba(15,23,42,0.08);
        padding: 1.75rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
        opacity: 0;
        transform: translateY(30px);
    }
    .app-card.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .app-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 45px rgba(15,23,42,0.15);
    }
    .app-card-media {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(14,165,233,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .app-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .app-card-media span {
        font-size: 1.5rem;
        font-weight: 600;
        color: #0f172a;
    }
    .app-card-title {
        font-size: 1.15rem;
        font-weight: 600;
        margin-bottom: 0.35rem;
    }
    .app-card p {
        color: #475569;
        margin-bottom: 1.5rem;
        flex: 1;
    }
    .app-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .app-chip {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: rgba(15,23,42,0.05);
        color: #0f172a;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
    }
    .btn-app-link {
        border-radius: 999px;
        padding: 0.55rem 1.2rem;
        font-weight: 600;
        color: #fff;
        border: none;
        background: var(--app-accent, #0f172a);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .btn-app-link:hover {
        transform: translateX(4px);
        color: #fff;
        filter: brightness(0.9);
    }
    .app-empty-state {
        text-align: center;
        padding: 3rem;
        border-radius: 1.25rem;
        background: #fff;
        border: 1px dashed rgba(15,23,42,0.15);
    }
    @media (max-width: 991px) {
        .app-featured { margin-top: 2rem; }
    }
</style>
@endpush

@section('content')
<section class="app-hero">
    <div class="container position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="app-pill"><i class="fa-solid fa-sitemap"></i> Portal Aplikasi</span>
                <h1 class="display-5 mb-3">Gerbang cepat ke seluruh layanan digital SMPN 4 Samarinda.</h1>
                <p class="lead text-white-50">Semua aplikasi akademik, layanan internal, hingga kanal publik kami satukan dalam satu muka portal agar warga sekolah tidak lagi mencari tautan di banyak tempat.</p>

                <div class="app-metrics">
                    <div class="app-metric-card">
                        <span>Total aplikasi</span>
                        <strong>{{ $metrics['total'] }}</strong>
                    </div>
                    <div class="app-metric-card">
                        <span>Ikon siap pakai</span>
                        <strong>{{ $metrics['withMedia'] }}</strong>
                    </div>
                    <div class="app-metric-card">
                        <span>Pembaruan</span>
                        <strong>{{ optional($metrics['recentlyUpdated'])->translatedFormat('d M Y') ?? '—' }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="app-featured">
                    @if($featured)
                        @if($featured->image_url)
                            <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}">
                        @else
                            <div class="rounded-3 bg-white bg-opacity-10 text-center text-white-50 py-5 mb-4" style="border: 1px dashed rgba(255,255,255,0.2);">
                                <i class="fa-solid fa-sitemap fa-2xl mb-3"></i>
                                <p class="mb-0">Belum ada poster untuk portal ini.</p>
                            </div>
                        @endif
                        <h4 class="fw-semibold">{{ $featured->title }}</h4>
                        <p class="text-white-50 mb-4">{{ $featured->description }}</p>
                        <a href="{{ $featured->link_url }}" target="_blank" rel="noopener" class="btn btn-warning text-dark fw-semibold">
                            {{ $featured->button_label }} <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                        </a>
                    @else
                        <div class="text-center text-white-50">
                            <i class="fa-solid fa-sitemap fa-3x mb-3"></i>
                            <p class="mb-1">Belum ada portal yang aktif.</p>
                            <span class="small">Admin dapat menambahkan melalui panel.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="app-grid-section">
    <div class="container position-relative" style="z-index:1;">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <p class="text-uppercase text-muted small mb-1">Daftar shortcut</p>
                <h2 class="fw-semibold mb-0">Semua aplikasi resmi SMPN 4 Samarinda</h2>
            </div>
            <a href="{{ route('kontak') }}" class="btn btn-outline-dark rounded-pill px-4">
                Butuh akses lain?
            </a>
        </div>

        @if($applications->isEmpty())
            <div class="app-empty-state">
                <h4 class="mb-2">Portal belum tersedia</h4>
                <p class="text-muted mb-0">Admin sedang menyiapkan tautan aplikasi. Silakan cek kembali beberapa waktu lagi.</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach($applications as $application)
                    @php
                        $accent = $application->accent_color ?: '#0f172a';
                        $initial = strtoupper(mb_substr($application->title, 0, 1));
                    @endphp
                    <div class="col">
                        <article class="app-card" data-app-card style="--app-accent: {{ $accent }};">
                            <div class="app-card-media" style="background: {{ $application->image_path ? 'transparent' : 'rgba(15,23,42,0.05)' }}; border: 1px solid rgba(15,23,42,0.05);">
                                @if($application->image_url)
                                    <img src="{{ $application->image_url }}" alt="{{ $application->title }}">
                                @else
                                    <span>{{ $initial }}</span>
                                @endif
                            </div>
                            <div class="app-card-title">{{ $application->title }}</div>
                            <p>{{ $application->description ?? 'Portal siap digunakan oleh guru, siswa, dan tenaga kependidikan.' }}</p>
                            <div class="app-card-footer">
                                <span class="app-chip">Prioritas #{{ $application->sort_order }}</span>
                                <a href="{{ $application->link_url }}" target="_blank" rel="noopener" class="btn-app-link">
                                    {{ $application->button_label }}
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('[data-app-card]');
        if (!cards.length) {
            return;
        }
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2,
        });
        cards.forEach((card) => observer.observe(card));
    });
</script>
@endpush
