@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="text-dinas fw-bold mb-4 border-bottom pb-2">Hubungi Kami</h2>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold">Alamat Sekolah</h5>
                    <!-- Gunakan null safe operator -->
                    <p>{{ $profil?->alamat ?? '-' }}</p>
                    <p>
                        <strong>Telepon:</strong> {{ $profil?->telepon ?? '-' }}<br>
                        <strong>Email:</strong> {{ $profil?->email ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Kirim Pesan</h5>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('kontak.kirim') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Pesan</label>
                            <textarea name="pesan" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
