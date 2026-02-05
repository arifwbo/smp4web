@extends('layouts.admin')

@section('title', 'Edit Akun Pengguna')
@section('page-title', 'Edit Akun Pengguna')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Akun Pengguna</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="card card-outline card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">Informasi Akun</h3>
                </div>
                <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah.</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Role</label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ old('role', $user->role) === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Admin</option>
                                    <option value="{{ \App\Models\User::ROLE_USER }}" {{ old('role', $user->role) === \App\Models\User::ROLE_USER ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status Akun</label>
                                <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                    <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $user->is_active) ? '' : 'selected' }}>Nonaktif</option>
                                </select>
                                @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Foto Profil</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @php
                                    $avatar = $user->profile_photo
                                        ? asset('storage/' . $user->profile_photo)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=96';
                                @endphp
                                <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle mr-3" width="72" height="72">
                                <div>
                                    <input type="file" name="profile_photo" class="form-control-file @error('profile_photo') is-invalid @enderror">
                                    <small class="form-text text-muted">Format jpg/jpeg/png, maksimal 2 MB.</small>
                                    @error('profile_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-outline card-warning mb-4" id="reset-password">
                <div class="card-header">
                    <h3 class="card-title">Reset Password</h3>
                </div>
                <form method="POST" action="{{ route('admin.users.reset-password', $user) }}">
                    @csrf
                    <div class="card-body">
                        @if(session('generated_password'))
                            <div class="alert alert-info">
                                Password baru: <code>{{ session('generated_password') }}</code>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Password Baru (opsional)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" placeholder="Isi untuk set manual">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="generate_password" value="1" class="form-check-input" id="generatePassword">
                            <label class="form-check-label" for="generatePassword">Generate otomatis (12 karakter)</label>
                        </div>
                        <small class="text-muted d-block mt-2">Jika keduanya diisi, sistem mendahulukan password manual.</small>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-key mr-1"></i> Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
