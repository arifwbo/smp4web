@php
    $isEdit = isset($slider);
@endphp
<div class="row">
    <div class="col-lg-8">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header"><h3 class="card-title">Konten Slider</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label>Judul *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $slider->title ?? '') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Subjudul</label>
                    <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $slider->subtitle ?? '') }}">
                    @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Label Tombol</label>
                        <input type="text" name="button_label" class="form-control @error('button_label') is-invalid @enderror" value="{{ old('button_label', $slider->button_label ?? 'Profil Sekolah') }}">
                        @error('button_label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Link Tombol</label>
                        <input type="url" name="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link', $slider->button_link ?? route('profil')) }}" placeholder="https://...">
                        @error('button_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-secondary card-outline">
            <div class="card-header"><h3 class="card-title">Pengaturan Tampilan</h3></div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Urutan</label>
                        <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $slider->sort_order ?? '') }}" min="0" max="999" placeholder="0">
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4 d-flex align-items-center mt-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">Tampilkan Slider</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-info card-outline">
            <div class="card-header"><h3 class="card-title">Gambar Slider</h3></div>
            <div class="card-body">
                <div class="mb-3 text-center">
                    @if($isEdit && $slider->image_path)
                        <img src="{{ asset('storage/' . $slider->image_path) }}" class="img-fluid rounded shadow-sm" alt="Preview slider">
                    @else
                        <div class="bg-light rounded p-4 text-muted">Belum ada gambar</div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Unggah Gambar {{ $isEdit ? '(opsional)' : '*' }}</label>
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" {{ $isEdit ? '' : 'required' }}>
                    <small class="form-text text-muted">Format JPG/PNG/WebP, maksimal 4 MB.<br>Rekomendasi ukuran 1920 x 1080 px (rasio 16:9).</small>
                    @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-warning btn-block"><i class="fas fa-save mr-2"></i>Simpan Slider</button>
                <a href="{{ route('admin.home-sliders.index') }}" class="btn btn-outline-secondary btn-block mt-2">Kembali</a>
            </div>
        </div>
    </div>
</div>
