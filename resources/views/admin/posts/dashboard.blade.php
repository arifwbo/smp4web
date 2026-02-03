@extends('layouts.admin')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item active bg-primary-custom border-primary-custom">Dashboard</a>
                <a href="{{ route('admin.posts.index') }}" class="list-group-item">Kelola Berita</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">Dashboard Admin</div>
                <div class="card-body">Selamat datang, Admin!</div>
            </div>
        </div>
    </div>
</div>
@endsection
