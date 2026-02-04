@extends('layouts.admin')
@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 col-md-8 mx-auto">
        <div class="card-header bg-primary-custom text-white">Tambah Berita</div>
        <div class="card-body">
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                    @error('judul')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control">
                        @foreach(['berita'=>'Berita','pengumuman'=>'Pengumuman','agenda'=>'Agenda','prestasi'=>'Prestasi'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('kategori', 'berita') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    @error('gambar')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Isi</label>
                    <textarea name="isi" class="form-control wysiwyg-editor" rows="5">{{ old('isi') }}</textarea>
                    @error('isi')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <button type="submit" class="btn btn-primary-custom">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
