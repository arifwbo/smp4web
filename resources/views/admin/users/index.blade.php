@extends('layouts.admin')

@section('title', 'Manajemen Akun Pengguna')
@section('page-title', 'Manajemen Akun Pengguna')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Akun Pengguna</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            @if(session('generated_password'))
                <div class="mt-2"><strong>Password Baru:</strong> <code>{{ session('generated_password') }}</code></div>
            @endif
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->has('status'))
        <div class="alert alert-danger">{{ $errors->first('status') }}</div>
    @endif
    @if($errors->has('delete'))
        <div class="alert alert-danger">{{ $errors->first('delete') }}</div>
    @endif

    <div class="card card-outline card-primary mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
            <form method="GET" class="form-inline flex-grow-1">
                <div class="input-group" style="max-width: 380px;">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau email...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn btn-warning">
                <i class="fas fa-user-plus mr-2"></i>Tambah Akun
            </a>
        </div>
    </div>

    <div class="card card-outline card-secondary">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th style="width: 220px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td class="font-weight-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->isAdmin() ? 'badge-danger' : 'badge-info' }}">
                                        {{ $user->isAdmin() ? 'Admin' : 'User' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $avatar = $user->profile_photo
                                            ? asset('storage/' . $user->profile_photo)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=64';
                                    @endphp
                                    <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle" width="48" height="48">
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button"
                                                class="btn btn-outline-info btn-reset-password"
                                                data-toggle="modal"
                                                data-target="#resetPasswordModal"
                                                data-action="{{ route('admin.users.reset-password', $user) }}"
                                                data-name="{{ $user->name }}">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" onsubmit="return confirm('Ubah status akun ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-{{ $user->is_active ? 'warning' : 'success' }}" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                                <i class="fas fa-power-off"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Hapus akun ini secara permanen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer border-top-0">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" class="modal-content" id="resetPasswordForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordLabel">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted" id="resetPasswordUser"></p>
                    <div class="form-group">
                        <label>Password Baru (opsional)</label>
                        <input type="password" name="password" class="form-control" minlength="8" placeholder="Minimal 8 karakter">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="generate_password" value="1" class="form-check-input" id="generatePass">
                        <label class="form-check-label" for="generatePass">Generate otomatis</label>
                    </div>
                    <small class="text-muted d-block mt-2">Password akan ditampilkan sekali setelah berhasil direset.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('resetPasswordModal');
        const form = document.getElementById('resetPasswordForm');
        const label = document.getElementById('resetPasswordUser');

        $('#resetPasswordModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const action = button.data('action');
            const name = button.data('name');

            form.action = action;
            label.textContent = `Reset password untuk: ${name}`;
            form.querySelector('input[name="password"]').value = '';
            form.querySelector('input[name="generate_password"]').checked = false;
        });
    });
</script>
@endpush
