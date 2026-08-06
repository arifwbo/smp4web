@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Informasi PPDB</h3>
        <a href="{{ route('admin.ppdb.create') }}" class="btn btn-primary-custom">Tambah Informasi</a>
    </div>
    <div class="card border-0 shadow-sm">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Link Pendaftaran</th>
                    <th>Lampiran</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ppdbs as $ppdb)
                <tr>
                    <td>{{ $ppdb->judul }}</td>
                    <td><span class="badge {{ $ppdb->status === 'buka' ? 'bg-success' : 'bg-secondary' }}">{{ strtoupper($ppdb->status) }}</span></td>
                    <td>
                        @forelse($ppdb->link_collection as $link)
                            <div>
                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener">
                                    {{ $link['label'] ?? parse_url($link['url'], PHP_URL_HOST) }}
                                </a>
                            </div>
                        @empty
                            <span class="text-muted">-</span>
                        @endforelse
                    </td>
                    <td>
                        @forelse($ppdb->lampiran_collection as $file)
                            <div>
                                <a href="{{ $file['url'] }}" target="_blank" rel="noopener">{{ $file['label'] ?? 'Lampiran' }}</a>
                            </div>
                        @empty
                            <span class="text-muted">-</span>
                        @endforelse
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.ppdb.edit', $ppdb) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.ppdb.destroy', $ppdb) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
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
        {{ $ppdbs->links() }}
    </div>
</div>
@endsection
