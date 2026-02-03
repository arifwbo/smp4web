@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Pesan Masuk</h3>
        <span class="text-muted small">Total {{ $messages->total() }} pesan</span>
    </div>
    <div class="card border-0 shadow-sm">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Masuk</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr class="{{ $message->read_at ? '' : 'table-warning' }}">
                    <td>{{ $message->nama }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($message->pesan, 60) }}</td>
                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada pesan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $messages->links() }}
    </div>
</div>
@endsection
