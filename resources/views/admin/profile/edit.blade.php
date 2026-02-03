@extends('layouts.admin')

@section('title', 'Profil Sekolah')
@section('page-title', 'Kelola Profil Sekolah')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profil Sekolah</li>
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

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Identitas Sekolah</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label>Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" value="{{ old('nama_sekolah', $profile->nama_sekolah) }}">
                                @error('nama_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>NPSN</label>
                                <input type="text" name="npsn" class="form-control @error('npsn') is-invalid @enderror" value="{{ old('npsn', $profile->npsn) }}">
                                @error('npsn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Akreditasi</label>
                                <input type="text" name="akreditasi" class="form-control @error('akreditasi') is-invalid @enderror" value="{{ old('akreditasi', $profile->akreditasi) }}">
                                @error('akreditasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kepala Sekolah</label>
                                <input type="text" name="kepala_sekolah" class="form-control @error('kepala_sekolah') is-invalid @enderror" value="{{ old('kepala_sekolah', $profile->kepala_sekolah) }}">
                                @error('kepala_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $profile->alamat) }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="card card-warning card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Visi, Misi & Tujuan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Sejarah Singkat</label>
                            <textarea name="sejarah" rows="4" class="form-control wysiwyg-editor @error('sejarah') is-invalid @enderror">{{ old('sejarah', $profile->sejarah) }}</textarea>
                            @error('sejarah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Visi</label>
                            <textarea name="visi" rows="3" class="form-control wysiwyg-editor @error('visi') is-invalid @enderror">{{ old('visi', $profile->visi) }}</textarea>
                            @error('visi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Misi</label>
                            <textarea name="misi" rows="4" class="form-control wysiwyg-editor @error('misi') is-invalid @enderror">{{ old('misi', $profile->misi) }}</textarea>
                            @error('misi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Tujuan</label>
                            <textarea name="tujuan" rows="3" class="form-control wysiwyg-editor @error('tujuan') is-invalid @enderror">{{ old('tujuan', $profile->tujuan) }}</textarea>
                            @error('tujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="card card-info card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Sambutan & Struktur</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Sambutan Kepala Sekolah</label>
                            <textarea name="sambutan_kepsek" rows="4" class="form-control wysiwyg-editor @error('sambutan_kepsek') is-invalid @enderror">{{ old('sambutan_kepsek', $profile->sambutan_kepsek) }}</textarea>
                            @error('sambutan_kepsek')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Struktur Organisasi (link atau deskripsi)</label>
                            <input type="text" name="struktur_organisasi" class="form-control @error('struktur_organisasi') is-invalid @enderror" value="{{ old('struktur_organisasi', $profile->struktur_organisasi) }}">
                            @error('struktur_organisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Maps Embed (iframe)</label>
                            <textarea name="maps_embed" rows="3" class="form-control @error('maps_embed') is-invalid @enderror">{{ old('maps_embed', $profile->maps_embed) }}</textarea>
                            @error('maps_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-secondary card-outline sticky-top" style="top: 80px;">
                    <div class="card-header">
                        <h3 class="card-title">Kontak & Aksi</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $logoPlaceholder = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="180" height="180" viewBox="0 0 180 180">
    <rect width="180" height="180" rx="40" fill="#f5f7fb"/>
    <text x="90" y="96" font-size="22" text-anchor="middle" fill="#94a3b8">Logo</text>
</svg>
SVG;
                            $logoImage = $profile->logo_path
                                ? asset('storage/' . $profile->logo_path)
                                : 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($logoPlaceholder);

                            $placeholderSvg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="320" height="320" viewBox="0 0 320 320">
    <rect width="320" height="320" fill="#f5f7fb"/>
    <circle cx="160" cy="120" r="60" fill="#dbeafe"/>
    <rect x="70" y="200" width="180" height="90" rx="45" fill="#dbeafe"/>
    <text x="160" y="305" font-size="26" text-anchor="middle" fill="#94a3b8">Kepala Sekolah</text>
</svg>
SVG;
                            $kepsekPhoto = $profile->foto_kepsek
                                ? asset('storage/' . $profile->foto_kepsek)
                                : 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($placeholderSvg);
                        @endphp
                        <div class="text-center mb-4">
                            <img src="{{ $logoImage }}" alt="Logo Sekolah" class="img-fluid mb-3" style="max-width: 160px;">
                            <div class="form-group text-left">
                                <label>Upload Logo Sekolah</label>
                                <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror">
                                <small class="form-text text-muted">Disarankan PNG latar transparan, maksimal 2 MB.</small>
                                @error('logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <img src="{{ $kepsekPhoto }}" alt="Foto Kepala Sekolah" class="img-fluid rounded-circle shadow-sm mb-2" style="max-width: 180px;">
                            <p class="mb-0 font-weight-bold">{{ $profile->kepala_sekolah }}</p>
                            <small class="text-muted d-block">Kepala Sekolah</small>
                        </div>
                        <div class="form-group">
                            <label>Upload Foto Kepala Sekolah</label>
                            <input type="file" name="foto_kepsek" class="form-control-file @error('foto_kepsek') is-invalid @enderror">
                            <small class="form-text text-muted">Format JPG/PNG/WebP, maksimal 3 MB.</small>
                            @error('foto_kepsek')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $profile->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $profile->telepon) }}">
                            @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat Footer</label>
                            <textarea name="footer_description" rows="3" class="form-control @error('footer_description') is-invalid @enderror" placeholder="Tuliskan tagline atau misi singkat sekolah">{{ old('footer_description', $profile->footer_description) }}</textarea>
                            @error('footer_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Link Facebook</label>
                            <input type="url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror" placeholder="https://facebook.com/smpn4" value="{{ old('facebook_url', $profile->facebook_url) }}">
                            @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Link Instagram</label>
                            <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" placeholder="https://instagram.com/smpn4" value="{{ old('instagram_url', $profile->instagram_url) }}">
                            @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Link YouTube</label>
                            <input type="url" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror" placeholder="https://youtube.com/@smpn4" value="{{ old('youtube_url', $profile->youtube_url) }}">
                            @error('youtube_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('profil') }}" class="btn btn-outline-secondary btn-block mt-2" target="_blank">
                            <i class="fas fa-eye mr-2"></i>Lihat Halaman Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
