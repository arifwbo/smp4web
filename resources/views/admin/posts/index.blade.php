@extends('layouts.admin')
@php use Illuminate\Support\Str; @endphp
@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap justify-content-between gap-3 mb-4 align-items-center">
        <div>
            <h3 class="mb-1">Kelola Berita</h3>
            <p class="text-muted small mb-0">Kelola konten informasi sekolah dengan pencarian, filter kategori, dan aksi massal.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus mr-2"></i>Tambah Berita
        </a>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-end g-3">
                <div class="col-md-6">
                    <label class="form-label small text-muted mb-1" for="search">Pencarian Judul</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" id="search" name="search" class="form-control" placeholder="Ketik judul berita..." value="{{ $searchQuery ?? '' }}">
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <label class="form-label small text-muted mb-1" for="category">Kategori</label>
                    <select name="category" id="category" class="form-select form-select-sm">
                        @foreach($categoryOptions as $value => $label)
                            <option value="{{ $value }}" @selected(($currentCategory ?? 'all') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-md-2">
                    <label class="form-label small text-muted mb-1" for="sort">Urutkan</label>
                    <select name="sort" id="sort" class="form-select form-select-sm">
                        @php
                            $sortOptions = [
                                'latest' => 'Terbaru',
                                'oldest' => 'Terlama',
                                'title_asc' => 'Judul A-Z',
                                'title_desc' => 'Judul Z-A',
                            ];
                        @endphp
                        @foreach($sortOptions as $value => $label)
                            <option value="{{ $value }}" @selected(($currentSort ?? 'latest') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-outline-primary w-100">Terapkan</button>
                </div>
            </div>
            @if(($searchQuery ?? '') || (($currentCategory ?? 'all') !== 'all'))
                <div class="mt-3 d-flex flex-wrap gap-2 align-items-center">
                    <span class="small text-muted">Filter aktif:</span>
                    @if($searchQuery ?? false)
                        <span class="badge badge-light text-dark">Cari: "{{ $searchQuery }}"</span>
                    @endif
                    @if(($currentCategory ?? 'all') !== 'all')
                        <span class="badge badge-light text-dark">Kategori: {{ $categoryOptions[$currentCategory] ?? ucfirst($currentCategory) }}</span>
                    @endif
                    <a href="{{ route('admin.posts.index') }}" class="small">Reset</a>
                </div>
            @endif
        </div>
    </form>

    <form method="POST" action="{{ route('admin.posts.bulk') }}" id="bulk-form" class="d-none">
        @csrf
        <input type="hidden" name="action" value="delete">
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-3">
            <label class="mb-0 d-flex align-items-center gap-2">
                <input type="checkbox" id="select-all" class="form-check-input">
                <span class="text-muted small">Pilih semua</span>
            </label>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="submit" form="bulk-form" class="btn btn-sm btn-outline-danger" id="bulk-delete" disabled onclick="return confirm('Hapus semua data terpilih?')">
                    <i class="fa-solid fa-trash-can me-1"></i>Hapus Terpilih
                </button>
                <span class="text-muted small">Total: {{ $posts->total() }} berita</span>
            </div>
        </div>
        <div class="card-body p-0">
            @forelse($posts as $post)
                @php
                    $cover = $post->gambar
                        ? asset('storage/' . $post->gambar)
                        : 'https://placehold.co/320x180?text=Berita';
                    $excerpt = Str::limit(strip_tags($post->isi), 140);
                @endphp
                <div class="border-bottom px-3 py-3 d-flex flex-wrap gap-3 align-items-center">
                    <div class="form-check me-2">
                        <input type="checkbox" form="bulk-form" name="selected[]" value="{{ $post->id }}" class="form-check-input post-checkbox">
                    </div>
                    <div class="flex-shrink-0" style="width: 200px;">
                        <div class="rounded overflow-hidden bg-light" style="height: 110px;">
                            <img src="{{ $cover }}" alt="{{ $post->judul }}" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 text-dark">{{ $post->judul }}</h5>
                        <div class="text-muted small mb-2 d-flex flex-wrap gap-3">
                            <span>Slug: {{ $post->slug }}</span>
                            <span>Terbit {{ $post->created_at->translatedFormat('d M Y') }}</span>
                            <span>Ditulis {{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mb-2 text-muted small">{{ $excerpt }}</p>
                        <span class="badge bg-secondary text-uppercase">{{ $post->kategori }}</span>
                    </div>
                    <div class="ml-auto d-flex gap-2 flex-wrap">
                        <a href="{{ route('berita.detail', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye mr-1"></i>Lihat
                        </a>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">Belum ada berita.</div>
            @endforelse
        </div>
        <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
            <small class="text-muted">
                Menampilkan {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} dari {{ $posts->total() }} berita
            </small>
            {{ $posts->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.post-checkbox');
        const bulkDeleteBtn = document.getElementById('bulk-delete');

        const updateBulkState = () => {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            bulkDeleteBtn.disabled = !anyChecked;
            if (!anyChecked) {
                selectAll.checked = false;
                selectAll.indeterminate = false;
                return;
            }

            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
            selectAll.indeterminate = !allChecked;
        };

        selectAll?.addEventListener('change', (event) => {
            checkboxes.forEach(cb => {
                cb.checked = event.target.checked;
            });
            updateBulkState();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', updateBulkState));
    });
</script>
@endpush
@endsection
