@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Pesan dari {{ $message->nama }}</h5>
                <small class="text-muted">Dikirim {{ $message->created_at->format('d M Y H:i') }}</small>
            </div>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>
            <p class="mb-1"><strong>Pesan:</strong></p>
            <p class="border rounded p-3 bg-light">{{ $message->pesan }}</p>
        </div>
        <div class="card-footer text-end bg-white">
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger">Hapus Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
