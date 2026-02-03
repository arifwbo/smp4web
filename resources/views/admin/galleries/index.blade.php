@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Galeri Foto</h3>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary-custom">Tambah Foto</a>
    </div>
    <div class="row g-4">
        @forelse($galleries as $item)
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm h-100">
                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" style="height:180px; object-fit:cover" alt="{{ $item->judul }}">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">{{ $item->judul }}</h6>
                    <p class="text-muted small flex-fill">{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.galleries.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.galleries.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada foto di galeri.</div>
        </div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
