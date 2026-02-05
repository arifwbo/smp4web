@extends('layouts.admin')

@section('title', 'Tambah Akun Pengguna')
@section('page-title', 'Tambah Akun Pengguna')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Akun Pengguna</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Formulir Akun Baru</h3>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ old('role') === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Admin</option>
                        <option value="{{ \App\Models\User::ROLE_USER }}" {{ old('role', \App\Models\User::ROLE_USER) === \App\Models\User::ROLE_USER ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Password Awal</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" required>
                    <small class="form-text text-muted">Minimal 8 karakter, campuran huruf dan angka lebih disarankan.</small>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
@endsection
