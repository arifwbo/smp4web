@extends('layouts.admin')

@section('page-title', 'Galeri Video')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Galeri Video</li>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Video Galeri</h3>
        <a href="{{ route('admin.gallery-videos.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Tambah Video</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            @forelse($videos as $video)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ $video->thumbnail_url }}" class="card-img-top" alt="{{ $video->judul }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <span class="badge badge-success mb-2"><i class="fas fa-video mr-1"></i>Youtube</span>
                            <h5 class="card-title">{{ $video->judul }}</h5>
                            <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($video->deskripsi, 90) }}</p>
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                                <div class="btn-group">
                                    <a href="{{ route('admin.gallery-videos.edit', $video) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form action="{{ route('admin.gallery-videos.destroy', $video) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">Belum ada video galeri. Tambahkan video pertama Anda.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $videos->links() }}
        </div>
    </div>
</div>
@endsection
