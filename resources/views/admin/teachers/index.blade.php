@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Guru & Tendik</h3>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary-custom">Tambah Data</a>
    </div>
    <div class="card border-0 shadow-sm">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jenis</th>
                    <th>Jabatan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->nama }}</td>
                    <td>{{ $teacher->nip ?? '-' }}</td>
                    <td><span class="badge bg-secondary">{{ strtoupper($teacher->jenis) }}</span></td>
                    <td>{{ $teacher->jabatan ?? '-' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $teachers->links() }}
    </div>
</div>
@endsection
