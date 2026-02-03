@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Galeri Sekolah</h1>
        <p class="text-muted">Dokumentasi kegiatan dan fasilitas terbaru SMPN 4 Samarinda.</p>
    </div>
    <div class="row g-4">
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
@endsection
