@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-3">
        <div>
            <h3 class="mb-1">Data Guru & Tendik</h3>
            <p class="text-muted mb-0">Kelola data GTK dengan pencarian, sortir, dan hapus massal.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap justify-content-md-end">
            <a href="{{ asset('storage/templates/guru_tendik_template.xlsx') }}" class="btn btn-outline-success" download>
                <i class="fas fa-download me-1"></i> Unduh Template
            </a>
            <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#importTeachersModal">
                <i class="fas fa-file-import me-1"></i> Import Data
            </button>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary-custom">Tambah Data</a>
        </div>
    </div>
    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-6">
            <label for="searchTeacher" class="form-label">Cari Guru / Tendik</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" name="q" id="searchTeacher" class="form-control" placeholder="Cari berdasarkan nama, NIP, atau jabatan" value="{{ request('q') }}">
            </div>
        </div>
        <div class="col-md-4">
            <label for="sortTeacher" class="form-label">Urutkan</label>
            <select name="sort" id="sortTeacher" class="form-control">
                <option value="latest" @selected(request('sort', 'latest') === 'latest')>Terbaru</option>
                <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Nama A-Z</option>
                <option value="name_desc" @selected(request('sort') === 'name_desc')>Nama Z-A</option>
                <option value="jenis" @selected(request('sort') === 'jenis')>Jenis GTK</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100">Terapkan</button>
        </div>
    </form>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="text-muted small">
            Menampilkan {{ $teachers->firstItem() ?? 0 }} - {{ $teachers->lastItem() ?? 0 }} dari {{ $teachers->total() }} data
        </div>
        <button type="submit" form="bulkDeleteForm" class="btn btn-outline-danger btn-sm" id="bulkDeleteBtn" disabled>Hapus Terpilih</button>
    </div>
    <div class="card border-0 shadow-sm">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllTeachers">
                        </div>
                    </th>
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
                    <td>
                        <div class="form-check">
                            <input class="form-check-input teacher-checkbox" type="checkbox" name="ids[]" value="{{ $teacher->id }}" form="bulkDeleteForm">
                        </div>
                    </td>
                    <td>{{ $teacher->nama }}</td>
                    <td>{{ $teacher->nip ?? '-' }}</td>
                    <td>
                        @if($teacher->jenis)
                            <span class="badge bg-secondary">{{ strtoupper($teacher->jenis) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
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
                    <td colspan="6" class="text-center text-muted">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
    <form id="bulkDeleteForm" action="{{ route('admin.teachers.bulk-destroy') }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
    <div class="mt-3">
        {{ $teachers->links() }}
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importTeachersModal" tabindex="-1" aria-labelledby="importTeachersLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('admin.teachers.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importTeachersLabel">Import Data Guru & Tendik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Unggah file CSV dengan struktur kolom berikut (urutan bebas):</p>
                <div class="table-responsive border rounded mb-3">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>nama</th>
                                <th>nip</th>
                                <th>jenis</th>
                                <th>jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Drs. Ahmad</td>
                                <td>19700101</td>
                                <td>pendidik</td>
                                <td>Guru Matematika</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="small text-muted mb-3">
                    <li>Gunakan nilai <strong>pendidik</strong> atau <strong>tendik</strong> pada kolom jenis.</li>
                    <li>NIP boleh dikosongkan, data tanpa nama akan dilewati.</li>
                    <li>Data dengan NIP sama akan diperbarui secara otomatis.</li>
                </ul>
                <div class="mb-3">
                    <label for="teacherImportFile" class="form-label">File CSV / Excel (.csv / .xlsx)</label>
                    <input type="file" name="file" id="teacherImportFile" class="form-control" accept=".csv,text/csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.xlsx" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary-custom">Mulai Import</button>
            </div>
        </form>
    </div>
</div>
@endsection

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('selectAllTeachers');
        const checkboxes = document.querySelectorAll('.teacher-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const bulkForm = document.getElementById('bulkDeleteForm');

        const refreshButtonState = () => {
            const boxArray = Array.from(checkboxes);
            const checked = boxArray.some((checkbox) => checkbox.checked);
            bulkDeleteBtn.disabled = !checked;
            if (selectAll) {
                selectAll.checked = boxArray.length > 0 && boxArray.every((checkbox) => checkbox.checked);
            }
        };

        if (selectAll) {
            selectAll.addEventListener('change', (event) => {
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = event.target.checked;
                });
                refreshButtonState();
            });
        }

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                refreshButtonState();
            });
        });

        if (bulkForm) {
            bulkForm.addEventListener('submit', (event) => {
                const confirmed = window.confirm('Hapus semua data yang dipilih? Tindakan ini tidak dapat dibatalkan.');
                if (!confirmed) {
                    event.preventDefault();
                }
            });
        }

        refreshButtonState();
    });
    </script>
    @endpush
