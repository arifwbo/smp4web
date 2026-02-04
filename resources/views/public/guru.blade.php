@extends('layouts.app')
@section('content')
@php
    $pendidik = $teachers->where('jenis', 'pendidik');
    $tendik = $teachers->where('jenis', 'tendik');
@endphp

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="text-dinas fw-bold mb-2">Direktori Guru & Tendik</h2>
        <p class="text-muted">Kenali para pendidik dan tenaga kependidikan yang mendukung kegiatan belajar di {{ $profil->nama_sekolah ?? 'sekolah kami' }}.</p>
    </div>

    <section id="pendidik" class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <p class="text-uppercase text-muted small mb-1">GTK</p>
                <h4 class="fw-bold">Kepala Sekolah & Guru</h4>
            </div>
            <span class="badge bg-primary">{{ $pendidik->count() }} orang</span>
        </div>
        <div class="row">
            @forelse($pendidik as $guru)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mx-auto bg-light rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <span class="fs-1 text-secondary">👩‍🏫</span>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $guru->nama }}</h5>
                            <p class="text-muted small mb-1">{{ $guru->jabatan }}</p>
                            <span class="badge bg-secondary">{{ $guru->nip ?? '-' }}</span>
                        </div>
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <p class="text-uppercase text-muted small mb-1">GTK</p>
                <h4 class="fw-bold">Tenaga Kependidikan</h4>
            </div>
            <span class="badge bg-primary">{{ $tendik->count() }} orang</span>
        </div>
        <div class="row">
            @forelse($tendik as $pegawai)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mx-auto bg-light rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <span class="fs-1 text-secondary">🧑‍💼</span>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $pegawai->nama }}</h5>
                            <p class="text-muted small mb-1">{{ $pegawai->jabatan }}</p>
                            <span class="badge bg-secondary">{{ $pegawai->nip ?? '-' }}</span>
                        </div>
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
