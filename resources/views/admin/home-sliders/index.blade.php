@extends('layouts.admin')

@section('title', 'Slider Beranda')
@section('page-title', 'Kelola Slider Beranda')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Slider Beranda</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="card-title mb-0">Daftar Slider</h3>
                <p class="text-muted small mb-0">Gunakan gambar rasio 16:9, resolusi ideal 1920x1080 px agar tampilan penuh layar tetap tajam.</p>
            </div>
            <a href="{{ route('admin.home-sliders.create') }}" class="btn btn-warning"><i class="fas fa-plus mr-2"></i>Tambah Slider</a>
        </div>
        <div class="card-body p-0">
            @forelse($sliders as $slider)
                <div class="border-bottom px-3 py-3 d-flex flex-wrap gap-3 align-items-center">
                    <div class="flex-shrink-0" style="width: 180px;">
                        <div class="rounded overflow-hidden bg-light" style="height: 100px;">
                            <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 text-dark">{{ $slider->title }}</h5>
                        <p class="mb-2 text-muted">{{ $slider->subtitle }}</p>
                        @if($slider->button_label && $slider->button_link)
                            <div class="small text-muted">
                                Tombol: <span class="text-primary">{{ $slider->button_label }}</span>
                                &mdash; <a href="{{ $slider->button_link }}" target="_blank">{{ $slider->button_link }}</a>
                            </div>
                        @endif
                    </div>
                    <div class="text-center" style="min-width: 80px;">
                        <div class="text-muted small">Urutan</div>
                        <span class="badge badge-pill badge-light border">{{ $slider->sort_order }}</span>
                    </div>
                    <div class="text-center" style="min-width: 90px;">
                        <div class="text-muted small">Status</div>
                        @if($slider->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Arsip</span>
                        @endif
                    </div>
                    <div class="text-right" style="min-width: 120px;">
                        <a href="{{ route('admin.home-sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary mr-1"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.home-sliders.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus slider ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">Belum ada slider. Klik "Tambah Slider" untuk membuat slide baru.</div>
            @endforelse
        </div>
    </div>
@endsection
