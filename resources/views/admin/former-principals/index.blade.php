@extends('layouts.admin')
@php use Illuminate\Support\Str; @endphp
@section('title', 'Kepala Sekolah Terdahulu')
@section('page-title', 'Kepala Sekolah Terdahulu')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kepala Sekolah Terdahulu</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-1">Daftar Kepala Sekolah</h5>
            <p class="text-muted small mb-0">Kelola riwayat kepemimpinan SMPN 4 Samarinda.</p>
        </div>
        <a href="{{ route('admin.former-principals.create') }}" class="btn btn-primary-custom"><i class="fas fa-plus mr-2"></i>Tambah Data</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @forelse($principals as $principal)
                <div class="border-bottom px-3 py-3 d-flex align-items-center gap-3 flex-wrap">
                    <div class="rounded-circle overflow-hidden" style="width:90px;height:90px;background:#f1f5f9;">
                        <img src="{{ $principal->photo_url }}" alt="{{ $principal->name }}" class="w-100 h-100" style="object-fit:cover;">
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">{{ $principal->name }}</h5>
                        <div class="d-flex flex-wrap gap-3 text-muted small mb-1">
                            <span><i class="fas fa-calendar mr-1"></i>{{ $principal->period ?? 'Periode tidak diisi' }}</span>
                            <span><i class="fas fa-sort mr-1"></i>Urutan {{ $principal->sort_order }}</span>
                        </div>
                        <p class="mb-0 text-muted">{{ Str::limit($principal->description, 140) }}</p>
                    </div>
                    <div class="btn-group btn-group-sm ml-auto" role="group">
                        <a href="{{ route('admin.former-principals.edit', $principal) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.former-principals.destroy', $principal) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">Belum ada data kepala sekolah terdahulu.</div>
            @endforelse
        </div>
    </div>
@endsection
