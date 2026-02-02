@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="text-dinas fw-bold mb-4 border-bottom pb-2">Sarana & Prasarana</h2>
    <div class="row">
        @foreach($facilities as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                    FOTO
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dinas">{{ $item->nama }}</h5>
                    <p class="card-text text-muted">{{ $item->deskripsi }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
