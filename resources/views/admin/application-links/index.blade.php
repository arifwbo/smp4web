@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4" style="gap: 1rem;">
        <div>
            <h3 class="mb-1">Portal Aplikasi Sekolah</h3>
            <p class="text-muted mb-0">Kelola shortcut ke aplikasi internal maupun layanan publik SMPN 4.</p>
        </div>
        <a href="{{ route('admin.application-links.create') }}" class="btn btn-primary-custom">
            <i class="fa-solid fa-plus me-2"></i>Tambah Portal
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Visual</th>
                        <th>Informasi</th>
                        <th>URL</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td style="width:120px;">
                                @if($application->image_path)
                                    <img src="{{ $application->image_url }}" class="img-fluid rounded-3" alt="{{ $application->title }}" style="max-height:80px; object-fit:cover;">
                                @else
                                    <div class="rounded-3 border d-flex flex-column align-items-center justify-content-center text-muted bg-light" style="height:80px;">
                                        <i class="fa-solid fa-sitemap fa-lg mb-2"></i>
                                        <small>Tanpa gambar</small>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                        <span class="fw-semibold">{{ $application->title }}</span>
                                        <span class="badge bg-white text-dark border" title="Urutan tampil">#{{ $application->sort_order }}</span>
                                    </div>
                                    <small class="text-muted mb-2">{{ \Illuminate\Support\Str::limit($application->description ?? '', 120) ?: 'Belum ada deskripsi' }}</small>
                                    <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                        <span class="small text-muted">Label tombol:</span>
                                        <span class="badge bg-light text-primary border">{{ $application->button_label }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ $application->link_url }}" target="_blank" rel="noopener" class="text-decoration-none small">
                                    {{ $application->link_url }}
                                </a>
                                @if($application->accent_color)
                                    <div class="d-flex align-items-center small text-muted mt-2" style="gap: 0.5rem;">
                                        <span class="color-chip" style="display:inline-block; width:18px; height:18px; border-radius:6px; border:1px solid #e5e7eb; background: {{ $application->accent_color }};"></span>
                                        {{ strtoupper($application->accent_color) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $application->is_active ? 'success' : 'secondary' }}">
                                    {{ $application->is_active ? 'Dipublikasikan' : 'Draft' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.application-links.edit', $application) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                <form action="{{ route('admin.application-links.destroy', $application) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus portal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada portal aplikasi yang tersimpan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $applications->links() }}
    </div>
</div>
@endsection
