@extends('layouts.app')
@section('content')
<div class="profile-hero py-5 mb-4">
    <div class="container">
        <p class="text-uppercase mb-2" style="color: rgba(255,255,255,0.75); letter-spacing: 0.12em; font-size: 0.8rem; font-weight: 600;">Kontak</p>
        <h1 class="fw-bold display-5 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #ffffff; text-shadow: 0 2px 12px rgba(0,0,0,0.25); letter-spacing: -0.02em;">Hubungi Kami</h1>
        <p class="lead mb-0" style="color: rgba(255,255,255,0.85); font-size: 1.05rem;">Kami siap menjawab pertanyaan dan menerima pesan dari Anda.</p>
    </div>
</div>
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 mb-4 reveal-segment" data-reveal="left">
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
        <div class="col-md-6 reveal-segment" data-reveal="right">
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
