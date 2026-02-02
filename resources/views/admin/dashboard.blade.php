@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 fw-bold mb-3">Dashboard Admin</h1>
            <p class="text-muted mb-4">Selamat datang kembali, {{ auth()->user()->name ?? 'Administrator' }}.</p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-uppercase text-muted">Total Berita</h6>
                        <p class="display-6 fw-bold mb-0">{{ \App\Models\Post::count() }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-uppercase text-muted">Guru</h6>
                        <p class="display-6 fw-bold mb-0">{{ \App\Models\Teacher::count() }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-uppercase text-muted">Fasilitas</h6>
                        <p class="display-6 fw-bold mb-0">{{ \App\Models\Facility::count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
