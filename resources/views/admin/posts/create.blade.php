@extends('layouts.admin')
@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 col-md-8 mx-auto">
        <div class="card-header bg-primary-custom text-white">Tambah Berita</div>
        <div class="card-body">
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3"><label>Judul</label><input type="text" name="judul" class="form-control" required></div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control">
                        @foreach(['berita'=>'Berita','pengumuman'=>'Pengumuman','agenda'=>'Agenda','prestasi'=>'Prestasi'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('kategori', 'berita') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3"><label>Gambar</label><input type="file" name="gambar" class="form-control"></div>
                <div class="mb-3"><label>Isi</label><textarea name="isi" class="form-control wysiwyg-editor" rows="5" required></textarea></div>
                <button type="submit" class="btn btn-primary-custom">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
