@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between mb-3">
        <h3>Kelola Berita</h3>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary-custom">Tambah Berita</a>
    </div>
    <div class="card border-0 shadow-sm">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Judul</th><th>Kategori</th><th>Tanggal</th></tr></thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->judul }}</td>
                    <td><span class="badge bg-secondary">{{ $post->kategori }}</span></td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
