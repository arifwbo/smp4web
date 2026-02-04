@extends('layouts.admin')

@section('page-title', 'Edit Video Galeri')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.gallery-videos.index') }}">Galeri Video</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Perbarui Video</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.gallery-videos.update', $video) }}" method="POST">
            @method('PUT')
            @include('admin.gallery-videos.partials.form', ['video' => $video])
        </form>
    </div>
</div>
@endsection
