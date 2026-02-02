@extends('layouts.app')
@section('content')
<div class="bg-primary-custom py-5 mb-5 text-white">
    <div class="container">
        <h1 class="fw-bold">Profil Sekolah</h1>
        <p class="lead mb-0">Mengenal Lebih Dekat SMP Negeri 4 Samarinda</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group shadow-sm sticky-top" style="top: 100px;">
                <a href="#identitas" class="list-group-item list-group-item-action active" data-bs-toggle="list">Identitas</a>
                <a href="#sejarah" class="list-group-item list-group-item-action" data-bs-toggle="list">Sejarah</a>
                <a href="#visi" class="list-group-item list-group-item-action" data-bs-toggle="list">Visi & Misi</a>
                <a href="#struktur" class="list-group-item list-group-item-action" data-bs-toggle="list">Struktur</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="identitas">
                    <div class="card shadow-sm border-0 mb-4"><div class="card-body"><h3 class="text-primary-custom fw-bold border-bottom pb-2 mb-3">Identitas Sekolah</h3><table class="table"><tr><th width="30%">Nama Sekolah</th><td>{{ $profil?->nama_sekolah }}</td></tr><tr><th>NPSN</th><td>{{ $profil?->npsn ?? '-' }}</td></tr><tr><th>Alamat</th><td>{{ $profil?->alamat }}</td></tr></table></div></div>
                </div>
                <div class="tab-pane fade" id="sejarah">
                    <div class="card shadow-sm border-0 mb-4"><div class="card-body"><h3 class="text-primary-custom fw-bold border-bottom pb-2 mb-3">Sejarah</h3><div class="lh-lg">{!! nl2br(e($profil?->sejarah ?? '-')) !!}</div></div></div>
                </div>
                <div class="tab-pane fade" id="visi">
                    <div class="card shadow-sm border-0 mb-4"><div class="card-body"><h3 class="text-primary-custom fw-bold border-bottom pb-2 mb-3">Visi & Misi</h3><div class="alert alert-info"><h5>Visi</h5>{{ $profil?->visi ?? '-' }}</div><div class="mt-3"><h5>Misi</h5><div class="bg-light p-3 rounded">{!! nl2br(e($profil?->misi ?? '-')) !!}</div></div></div></div>
                </div>
                <div class="tab-pane fade" id="struktur">
                    <div class="card shadow-sm border-0 mb-4"><div class="card-body"><h3 class="text-primary-custom fw-bold border-bottom pb-2 mb-3">Struktur Organisasi</h3><p class="text-muted text-center py-5">Gambar struktur belum diunggah.</p></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>document.addEventListener("DOMContentLoaded",function(){var t=[].slice.call(document.querySelectorAll(".list-group-item"));t.forEach(function(e){var n=new bootstrap.Tab(e);e.addEventListener("click",function(t){t.preventDefault(),n.show()})})});</script>
@endsection
