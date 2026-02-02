@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="p-5 mb-4 bg-light border rounded-3 text-center">
        <h1 class="display-5 fw-bold text-dinas">PPDB Online</h1>
        <p class="fs-4">Informasi Penerimaan Peserta Didik Baru</p>
    </div>

    @if($ppdb)
        <div class="card shadow-sm">
            <div class="card-header bg-dinas text-white fw-bold">
                {{ $ppdb->judul }}
            </div>
            <div class="card-body">
                <div class="mb-4">
                    {!! nl2br(e($ppdb->konten)) !!}
                </div>

                @if($ppdb->status == 'buka')
                    <div class="alert alert-success text-center">
                        <h4 class="alert-heading">Pendaftaran DIBUKA!</h4>
                        <p>Silakan klik tombol di bawah untuk mendaftar.</p>
                        <a href="{{ $ppdb->link_daftar }}" class="btn btn-primary btn-lg mt-2">Daftar Sekarang</a>
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        <h4 class="alert-heading">Pendaftaran DITUTUP</h4>
                        <p>Mohon maaf, periode pendaftaran belum dibuka atau sudah berakhir.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">Belum ada informasi PPDB saat ini.</div>
    @endif
</div>
@endsection
