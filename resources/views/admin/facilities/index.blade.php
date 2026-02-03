@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Fasilitas Sekolah</h3>
        <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary-custom">Tambah Fasilitas</a>
    </div>
    <div class="card border-0 shadow-sm">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facilities as $facility)
                <tr>
                    <td>{{ $facility->nama }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($facility->deskripsi, 80) }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $facilities->links() }}
    </div>
</div>
@endsection
