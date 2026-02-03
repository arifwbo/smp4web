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
            <img src="{{ $post->gambar_url }}" class="img-fluid rounded w-100 mb-4 shadow-sm" alt="{{ $post->judul }}">
            <div class="lh-lg text-justify">{!! $post->isi !!}</div>
        </div>
    </div>
</div>
@endsection
