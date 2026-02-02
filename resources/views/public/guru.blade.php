@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="text-dinas fw-bold mb-4 border-bottom pb-2">Direktori Guru & Staff</h2>
    <div class="row">
        @foreach($teachers as $guru)
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="mx-auto bg-light rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                        <span class="fs-1 text-secondary">👤</span>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $guru->nama }}</h5>
                    <p class="text-muted small mb-1">{{ $guru->jabatan }}</p>
                    <span class="badge bg-secondary">{{ $guru->nip ?? '-' }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
