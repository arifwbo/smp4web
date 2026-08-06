@extends('layouts.app')
@section('content')
@php
    $pendidik = $teachers->where('jenis', 'pendidik');
    $tendik = $teachers->where('jenis', 'tendik');

    $avatarPendidikSvg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
    <circle cx="50" cy="50" r="50" fill="#eff6ff"/>
    <circle cx="50" cy="40" r="22" fill="#bfdbfe"/>
    <path d="M18 90 C 18 68, 82 68, 82 90 Z" fill="#bfdbfe"/>
</svg>
SVG;
    $defaultPendidikPhoto = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($avatarPendidikSvg);

    $avatarTendikSvg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
    <circle cx="50" cy="50" r="50" fill="#fef3c7"/>
    <circle cx="50" cy="40" r="22" fill="#fde68a"/>
    <path d="M18 90 C 18 68, 82 68, 82 90 Z" fill="#fde68a"/>
</svg>
SVG;
    $defaultTendikPhoto = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($avatarTendikSvg);
@endphp

<div class="profile-hero py-5 mb-0">
    <div class="container">
        <p class="text-uppercase mb-2" style="color: rgba(255,255,255,0.75); letter-spacing: 0.12em; font-size: 0.8rem; font-weight: 600;">Direktori GTK</p>
        <h1 class="fw-bold display-5 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #ffffff; text-shadow: 0 2px 12px rgba(0,0,0,0.25); letter-spacing: -0.02em;">Guru &amp; Tenaga Kependidikan</h1>
        <p class="lead mb-0" style="color: rgba(255,255,255,0.85); font-size: 1.05rem;">Kenali para pendidik dan tenaga kependidikan SMPN 4 Samarinda.</p>
    </div>
</div>
<div class="container py-5">
    <section id="pendidik" class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 reveal-segment" data-aos="fade-up">
            <div>
                <p class="text-uppercase text-muted small mb-1 fw-bold">Tenaga Pendidik</p>
                <h4 class="fw-bold mb-0">Kepala Sekolah &amp; Guru</h4>
            </div>
            <span class="badge" style="background:var(--accent-light); color:var(--accent); font-size:0.85rem; font-weight:700;">{{ $pendidik->count() }} orang</span>
        </div>
        <div class="row g-4">
            @forelse($pendidik as $guru)
                @php
                    $photoUrl = $guru->foto
                        ? url('media/' . ltrim(preg_replace('/^(storage\/|media\/)+/', '', $guru->foto), '/'))
                        : $defaultPendidikPhoto;
                @endphp
                <div class="col-sm-6 col-md-4 col-lg-3 reveal-segment" data-aos="fade-up">
                    <div class="gtk-card text-center h-100">
                        <div class="gtk-photo mb-3">
                            <img src="{{ $photoUrl }}" alt="{{ $guru->nama }}" loading="lazy" onerror="this.onerror=null; this.src='{{ $defaultPendidikPhoto }}';">
                        </div>
                        <h5 class="fw-bold mb-1 fs-6">{{ $guru->nama }}</h5>
                        <p class="text-muted small mb-2">{{ $guru->jabatan ?? 'Guru' }}</p>
                        @if($guru->nip)
                            <span class="badge bg-light text-dark border">{{ $guru->nip }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">Data guru belum tersedia.</div>
                </div>
            @endforelse
        </div>
    </section>

    <section id="tendik">
        <div class="d-flex justify-content-between align-items-center mb-4 reveal-segment" data-aos="fade-up">
            <div>
                <p class="text-uppercase text-muted small mb-1 fw-bold">Tenaga Kependidikan</p>
                <h4 class="fw-bold mb-0">Staf &amp; Tata Usaha</h4>
            </div>
            <span class="badge" style="background:var(--gold-light); color:var(--gold-dark); font-size:0.85rem; font-weight:700;">{{ $tendik->count() }} orang</span>
        </div>
        <div class="row g-4">
            @forelse($tendik as $pegawai)
                @php
                    $photoUrl = $pegawai->foto
                        ? url('media/' . ltrim(preg_replace('/^(storage\/|media\/)+/', '', $pegawai->foto), '/'))
                        : $defaultTendikPhoto;
                @endphp
                <div class="col-sm-6 col-md-4 col-lg-3 reveal-segment" data-aos="fade-up">
                    <div class="gtk-card text-center h-100">
                        <div class="gtk-photo mb-3">
                            <img src="{{ $photoUrl }}" alt="{{ $pegawai->nama }}" loading="lazy" onerror="this.onerror=null; this.src='{{ $defaultTendikPhoto }}';">
                        </div>
                        <h5 class="fw-bold mb-1 fs-6">{{ $pegawai->nama }}</h5>
                        <p class="text-muted small mb-2">{{ $pegawai->jabatan ?? 'Staf' }}</p>
                        @if($pegawai->nip)
                            <span class="badge bg-light text-dark border">{{ $pegawai->nip }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">Data tenaga kependidikan belum tersedia.</div>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
