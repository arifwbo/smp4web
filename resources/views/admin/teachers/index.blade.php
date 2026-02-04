@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-3">
        <div>
            <h3 class="mb-1">Data Guru & Tendik</h3>
            <p class="text-muted mb-0">Tambah cepat dengan unggah file CSV (nama, nip, jenis, jabatan).</p>
        </div>
        <div class="d-flex gap-2 flex-wrap justify-content-md-end">
            <a href="{{ asset('storage/templates/guru_tendik_template.xlsx') }}" class="btn btn-outline-success" download>
                <i class="fas fa-download me-1"></i> Unduh Template
            </a>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importTeachersModal">
                <i class="fas fa-file-import me-1"></i> Import Data
            </button>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary-custom">Tambah Data</a>
        </div>
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

<!-- Import Modal -->
<div class="modal fade" id="importTeachersModal" tabindex="-1" aria-labelledby="importTeachersLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('admin.teachers.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importTeachersLabel">Import Data Guru & Tendik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <label for="teacherImportFile" class="form-label">File CSV</label>
                    <input type="file" name="file" id="teacherImportFile" class="form-control" accept=".csv,text/csv" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary-custom">Mulai Import</button>
            </div>
        </form>
    </div>
</div>
@endsection
