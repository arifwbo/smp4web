@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Fasilitas Sekolah</h3>
        <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary-custom">Tambah Fasilitas</a>
    </div>
    @php
        $categoryMeta = \App\Models\Facility::categoryMeta();
        $conditionMeta = \App\Models\Facility::conditionMeta();
    @endphp

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Dokumentasi</th>
                        <th>Fasilitas</th>
                        <th>Kategori</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                    <tr>
                        <td style="width:120px;">
                            @if($facility->foto_path)
                                <img src="{{ asset('storage/' . $facility->foto_path) }}" class="img-fluid rounded" style="max-height:80px; object-fit:cover;" alt="Foto {{ $facility->nama }}">
                            @else
                                <div class="bg-light border rounded text-center py-4 text-muted small">Belum ada foto</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold text-primary">{{ $facility->nama }}</div>
                            <div class="text-muted small">{{ \Illuminate\Support\Str::limit($facility->deskripsi, 90) }}</div>
                            <div class="small text-muted mt-1">Jumlah: <strong>{{ $facility->jumlah ?? '-' }}</strong> unit</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <i class="fa-solid {{ $categoryMeta[$facility->kategori]['icon'] ?? 'fa-layer-group' }} me-1"></i>
                                {{ $categoryMeta[$facility->kategori]['label'] ?? 'Tidak terdefinisi' }}
                            </span>
                        </td>
                        <td>
                            @php($condition = $conditionMeta[$facility->kondisi] ?? ['label' => 'N/A', 'badge' => 'secondary'])
                            <span class="badge bg-{{ $condition['badge'] }}">{{ $condition['label'] }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $facility->status_publish ? 'primary' : 'secondary' }}">{{ $facility->status_publish ? 'Dipublikasikan' : 'Draft' }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                            <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $facilities->links() }}
    </div>
</div>
@endsection
