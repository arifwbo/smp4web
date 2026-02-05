@extends('layouts.admin')

@section('title', 'Profil Sekolah')
@section('page-title', 'Kelola Profil Sekolah')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profil Sekolah</li>
@endsection

@section('content')
    @php
        $guruStructureFields = [
            'pimpinan_manajemen' => 'Pimpinan & Manajemen',
            'komite_sekolah' => 'Komite Sekolah',
            'kepala_sekolah' => 'Kepala Sekolah',
            'waka_kerjasama' => 'Waka Bidang Manajemen Kerjasama & Kehumasan',
            'waka_kurikulum' => 'Waka Bidang Kurikulum',
            'waka_sarpras' => 'Waka Bidang Sarana Prasarana',
            'waka_kesiswaan' => 'Waka Bidang Kesiswaan',
        ];

        $tuStructureFields = [
            'staf_tata_usaha' => 'Staf Tata Usaha',
            'koordinator_media_bosda' => 'Koordinator Ruang Media & Bendahara BOSDA',
            'bendahara_barang' => 'Bendahara Barang',
            'bendahara_bosp' => 'Bendahara BOSP',
            'kepegawaian' => 'Kepegawaian',
            'pengantar_surat_kesiswaan' => 'Pengantar Surat / Kesiswaan',
            'sapras_surat_menyurat' => 'Sapras / Surat Menyurat',
            'operator_dapodik_kesiswaan' => 'Operator Dapodik / Kesiswaan',
            'staf_kepsek_kurikulum' => 'Staf Kepala Sekolah dan Kurikulum',
            'perpustakaan' => 'Perpustakaan',
            'lab_komputer_teknisi' => 'Lab. Komputer dan Teknisi',
            'laboratorium_ipa' => 'Laboratorium IPA',
            'petugas_kebersihan' => 'Petugas Kebersihan',
            'petugas_taman_kebersihan' => 'Petugas Taman & Kebersihan',
            'petugas_keamanan' => 'Petugas Keamanan Sekolah',
            'penjaga_malam' => 'Penjaga Malam',
        ];
        $strukturGuruValues = old('struktur_guru', $profile->struktur_guru ?? []);
        $strukturTuValues = old('struktur_tu', $profile->struktur_tu ?? []);
        $contactEmail = old('email', $profile->email) ?: 'Belum diisi';
        $contactPhone = old('telepon', $profile->telepon) ?: 'Belum diisi';
        $whatsappNumber = old('whatsapp_number', $profile->whatsapp_number) ?: 'Belum diisi';
        $lastUpdatedReadable = optional($profile->updated_at)->translatedFormat('d F Y, H:i');
    @endphp
    <div class="profile-admin-page">
        <div class="page-intro-card shadow-sm">
            <div class="intro-text">
                <h2 class="intro-title">Kelola Profil Sekolah</h2>
                <p class="mb-3">Pastikan seluruh informasi sekolah selalu mutakhir agar tampil profesional pada halaman publik.</p>
                <div class="intro-chips">
                    <span class="intro-chip">Terakhir diperbarui: {{ $lastUpdatedReadable ?? 'Belum pernah' }}</span>
                    <span class="intro-chip intro-chip-accent">Informasi dipublikasikan ke laman utama</span>
                </div>
            </div>
            <div class="quick-meta">
                <div class="meta-tile">
                    <span class="meta-label">Email Utama</span>
                    <span class="meta-value">{{ $contactEmail }}</span>
                </div>
                <div class="meta-tile">
                    <span class="meta-label">Telepon</span>
                    <span class="meta-value">{{ $contactPhone }}</span>
                </div>
                <div class="meta-tile">
                    <span class="meta-label">WhatsApp</span>
                    <span class="meta-value">{{ $whatsappNumber }}</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success soft-alert alert-dismissible fade show" role="alert">
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
                    <div class="card admin-card mb-4">
                        <div class="card-header border-0 bg-transparent d-flex flex-column flex-md-row justify-content-between align-items-start pb-0">
                            <div>
                                <h3 class="card-title mb-1">Identitas Sekolah</h3>
                                <p class="text-muted mb-0">Perbarui data dasar sekolah sehingga konsisten di seluruh halaman.</p>
                            </div>
                            <span class="badge badge-soft badge-primary mt-3 mt-md-0">Wajib</span>
                        </div>
                        <div class="card-body">
                            <div class="row gutters-sm">
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
                            <div class="row gutters-sm">
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
                            <div class="form-group mb-0">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $profile->alamat) }}</textarea>
                                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="card admin-card mb-4">
                        <div class="card-header border-0 bg-transparent d-flex flex-column flex-md-row justify-content-between align-items-start pb-0">
                            <div>
                                <h3 class="card-title mb-1">Visi, Misi & Tujuan</h3>
                                <p class="text-muted mb-0">Gunakan editor kaya fitur untuk menuliskan narasi lengkap.</p>
                            </div>
                            <span class="badge badge-soft badge-warning mt-3 mt-md-0">Konten</span>
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
                            <div class="form-group mb-0">
                                <label>Tujuan</label>
                                <textarea name="tujuan" rows="3" class="form-control wysiwyg-editor @error('tujuan') is-invalid @enderror">{{ old('tujuan', $profile->tujuan) }}</textarea>
                                @error('tujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="card admin-card mb-4">
                        <div class="card-header border-0 bg-transparent d-flex flex-column flex-md-row justify-content-between align-items-start pb-0">
                            <div>
                                <h3 class="card-title mb-1">Sambutan & Struktur</h3>
                                <p class="text-muted mb-0">Dokumentasikan sambutan resmi serta susunan organisasi sekolah.</p>
                            </div>
                            <span class="badge badge-soft badge-info mt-3 mt-md-0">Profil</span>
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
                            <div class="row gutters-sm">
                                <div class="form-group col-md-6">
                                    <label>Upload Gambar Struktur Guru</label>
                                    @if($profile->struktur_guru_image)
                                        <div class="upload-preview mb-2">
                                            <img src="{{ asset('storage/' . $profile->struktur_guru_image) }}" alt="Struktur Guru" class="img-fluid rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="struktur_guru_image" class="form-control-file @error('struktur_guru_image') is-invalid @enderror">
                                    <small class="form-text text-muted">Format JPG/PNG/WebP, maksimal 4 MB.</small>
                                    @error('struktur_guru_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Upload Gambar Struktur TU</label>
                                    @if($profile->struktur_tu_image)
                                        <div class="upload-preview mb-2">
                                            <img src="{{ asset('storage/' . $profile->struktur_tu_image) }}" alt="Struktur TU" class="img-fluid rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="struktur_tu_image" class="form-control-file @error('struktur_tu_image') is-invalid @enderror">
                                    <small class="form-text text-muted">Format JPG/PNG/WebP, maksimal 4 MB.</small>
                                    @error('struktur_tu_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row gutters-sm">
                                <div class="col-md-6">
                                    <div class="structure-card h-100">
                                        <h5 class="structure-title text-primary"><i class="fas fa-chalkboard-teacher mr-2"></i>Struktur Organisasi Guru</h5>
                                        <div class="structure-grid">
                                            @foreach($guruStructureFields as $fieldKey => $label)
                                                <div class="form-group mb-3">
                                                    <label class="small text-muted d-block">{{ $label }}</label>
                                                    <input
                                                        type="text"
                                                        name="struktur_guru[{{ $fieldKey }}]"
                                                        class="form-control @error('struktur_guru.' . $fieldKey) is-invalid @enderror"
                                                        value="{{ old('struktur_guru.' . $fieldKey, $strukturGuruValues[$fieldKey] ?? '') }}"
                                                        placeholder="Nama penanggung jawab"
                                                    >
                                                    @error('struktur_guru.' . $fieldKey)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="structure-card h-100">
                                        <h5 class="structure-title text-success"><i class="fas fa-users-cog mr-2"></i>Struktur Organisasi TU</h5>
                                        <div class="structure-grid">
                                            @foreach($tuStructureFields as $fieldKey => $label)
                                                <div class="form-group mb-3">
                                                    <label class="small text-muted d-block">{{ $label }}</label>
                                                    <input
                                                        type="text"
                                                        name="struktur_tu[{{ $fieldKey }}]"
                                                        class="form-control @error('struktur_tu.' . $fieldKey) is-invalid @enderror"
                                                        value="{{ old('struktur_tu.' . $fieldKey, $strukturTuValues[$fieldKey] ?? '') }}"
                                                        placeholder="Nama penanggung jawab"
                                                    >
                                                    @error('struktur_tu.' . $fieldKey)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label>Maps Embed (iframe)</label>
                                <textarea name="maps_embed" rows="3" class="form-control @error('maps_embed') is-invalid @enderror">{{ old('maps_embed', $profile->maps_embed) }}</textarea>
                                @error('maps_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card admin-card summary-card sticky-top" style="top: 90px;">
                        <div class="card-header border-0 bg-transparent pb-0">
                            <h3 class="card-title mb-1">Kontak & Aksi</h3>
                            <p class="text-muted mb-0">Unggah identitas visual serta saluran komunikasi sekolah.</p>
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
                                <div class="upload-preview logo-preview mb-3">
                                    <img src="{{ $logoImage }}" alt="Logo Sekolah" class="img-fluid">
                                </div>
                                <div class="form-group text-left mb-4">
                                    <label>Upload Logo Sekolah</label>
                                    <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror">
                                    <small class="form-text text-muted">Disarankan PNG latar transparan, maksimal 2 MB.</small>
                                    @error('logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="upload-preview avatar-preview mb-2">
                                    <img src="{{ $kepsekPhoto }}" alt="Foto Kepala Sekolah" class="img-fluid rounded-circle">
                                </div>
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
                                <label>Nomor WhatsApp</label>
                                <div class="input-group @error('whatsapp_number') has-validation @enderror">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-whatsapp text-success"></i></span>
                                    </div>
                                    <input type="text" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror" placeholder="Contoh: 6281234567890" value="{{ old('whatsapp_number', $profile->whatsapp_number) }}">
                                    @error('whatsapp_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <small class="form-text text-muted">Gunakan format internasional tanpa simbol atau spasi.</small>
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
                            <button type="submit" class="btn btn-gradient w-100">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('profil') }}" class="btn btn-outline-soft w-100 mt-2" target="_blank">
                                <i class="fas fa-eye mr-2"></i>Lihat Halaman Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
.profile-admin-page {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.page-intro-card {
    background: linear-gradient(120deg, rgba(1, 42, 99, 0.92), rgba(1, 22, 58, 0.96));
    border-radius: 1.25rem;
    padding: 2rem;
    color: #fff;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 1.5rem;
}

.intro-title {
    font-size: 1.5rem;
    font-weight: 700;
}

.intro-chips {
    display: flex;
    flex-wrap: wrap;
    margin: -0.25rem;
}

.intro-chip {
    background: rgba(255, 255, 255, 0.12);
    border-radius: 999px;
    padding: 0.4rem 1rem;
    font-size: 0.85rem;
    margin: 0.25rem;
}

.intro-chip-accent {
    background: var(--admin-accent, #fbbf24);
    color: #1f2937;
    font-weight: 600;
}

.quick-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 0.75rem;
    min-width: 260px;
}

.meta-tile {
    background: rgba(255, 255, 255, 0.12);
    border-radius: 1rem;
    padding: 0.85rem 1rem;
}

.meta-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    opacity: 0.8;
}

.meta-value {
    display: block;
    font-size: 0.95rem;
    font-weight: 600;
}

.admin-card {
    border-radius: 1.25rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 15px 35px rgba(15, 23, 42, 0.07);
}

.admin-card .card-header {
    padding: 1.5rem 1.5rem 0;
}

.admin-card .card-body {
    padding: 1.5rem;
}

.badge-soft {
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    font-weight: 600;
    background: rgba(1, 42, 99, 0.08);
    color: var(--admin-brand, #012a63);
}

.badge-soft.badge-warning {
    color: var(--admin-accent-dark, #f59e0b);
    background: rgba(251, 191, 36, 0.15);
}

.badge-soft.badge-info {
    color: #0c4a6e;
    background: rgba(14, 165, 233, 0.15);
}

.soft-alert {
    border-radius: 1rem;
    border: none;
    background: rgba(34, 197, 94, 0.1);
    color: #065f46;
}

.row.gutters-sm {
    margin-left: -0.5rem;
    margin-right: -0.5rem;
}

.row.gutters-sm > [class*="col-"] {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.structure-card {
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 1.25rem;
    background: #fdfdfd;
}

.structure-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.structure-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
}

.upload-preview {
    border: 1px dashed #cbd5f5;
    background: #f8fafc;
    border-radius: 1rem;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-preview img {
    max-width: 100%;
    height: auto;
}

.logo-preview {
    padding: 1.25rem;
}

.avatar-preview img {
    width: 140px;
    height: 140px;
    object-fit: cover;
}

.btn-gradient {
    background: linear-gradient(115deg, var(--admin-brand, #012a63), var(--admin-accent, #fbbf24));
    color: #fff;
    border: none;
    font-weight: 600;
    transition: opacity 0.2s ease;
}

.btn-gradient:hover {
    color: #fff;
    opacity: 0.9;
}

.btn-outline-soft {
    border: 1px solid #cbd5f5;
    color: #0f172a;
    font-weight: 600;
    border-radius: 0.85rem;
}

.btn-outline-soft:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.summary-card .form-group:not(:last-child) {
    margin-bottom: 1rem;
}

@media (max-width: 767.98px) {
    .page-intro-card {
        padding: 1.5rem;
    }
}
</style>
@endpush
