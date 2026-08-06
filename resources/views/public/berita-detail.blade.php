@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-primary-custom">Beranda</a></li>
                    <li class="breadcrumb-item active">Berita</li>
                </ol>
            </nav>
            <h1 class="fw-bold text-primary-custom mb-3">{{ $post->judul }}</h1>
            <div class="text-muted mb-4 small"><i class="fas fa-calendar me-1"></i> {{ $post->created_at->format('d F Y') }}</div>
                @if($post->kategori === 'pengumuman' && $post->lampiran_url)
                    <div class="mb-4">
                        <a href="{{ $post->lampiran_url }}" class="btn btn-outline-primary btn-sm" download>
                            <i class="fas fa-download me-1"></i> Unduh Lampiran Pengumuman
                        </a>
                    </div>
                @endif
            <img src="{{ $post->gambar_url }}" class="img-fluid rounded w-100 mb-4 shadow-sm" alt="{{ $post->judul }}" onerror="this.onerror=null; this.src='{{ asset('img/placeholder.jpg') }}';">
            <div class="lh-lg text-justify">{!! $post->isi !!}</div>
        </div>
    </div>
</div>
@endsection
