@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 col-md-8 mx-auto">
        <div class="card-header bg-primary-custom text-white">Edit Berita</div>
        <div class="card-body">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $post->judul) }}" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control">
                        @foreach(['berita'=>'Berita','pengumuman'=>'Pengumuman','agenda'=>'Agenda','prestasi'=>'Prestasi'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('kategori', $post->kategori) === $value)> {{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    @if($post->gambar)
                        <small class="text-muted">Saat ini: {{ $post->gambar }}</small>
                    @endif
                </div>
                <div class="mb-3">
                    <label>Isi</label>
                    <textarea name="isi" class="form-control wysiwyg-editor" rows="5" required>{{ old('isi', $post->isi) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
