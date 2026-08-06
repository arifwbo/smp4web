@php
    $currentAccent = old('accent_color', $application->accent_color ?? '') ?: '#0f172a';
@endphp

<div class="mb-3">
    <label class="form-label fw-semibold">Nama Portal</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $application->title ?? '') }}" required>
    @error('title')<div class="small text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Deskripsi Singkat</label>
    <textarea name="description" class="form-control" rows="3" placeholder="Cerita singkat manfaat aplikasi.">{{ old('description', $application->description ?? '') }}</textarea>
    @error('description')<div class="small text-danger">{{ $message }}</div>@enderror
</div>

<div class="row g-3">
    <div class="col-md-7">
        <label class="form-label fw-semibold">URL Aplikasi</label>
        <input type="url" name="link_url" class="form-control" placeholder="https://" value="{{ old('link_url', $application->link_url ?? '') }}" required>
        @error('link_url')<div class="small text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-5">
        <label class="form-label fw-semibold">Label Tombol</label>
        <input type="text" name="button_label" class="form-control" value="{{ old('button_label', $application->button_label ?? 'Buka Aplikasi') }}" maxlength="60">
        @error('button_label')<div class="small text-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Aksen Warna (opsional)</label>
        <div class="input-group">
            <span class="input-group-text p-0">
                <span class="d-inline-block" style="width:38px; height:38px; background: {{ $currentAccent }}; border-radius: 10px;"></span>
            </span>
            <input type="text" name="accent_color" class="form-control" placeholder="#0F172A" value="{{ old('accent_color', $application->accent_color ?? '') }}">
        </div>
        <small class="text-muted">Gunakan format hex, contoh <code>#0F172A</code>.</small>
        @error('accent_color')<div class="small text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label fw-semibold">Urutan</label>
        <input type="number" name="sort_order" class="form-control" min="0" max="999" value="{{ old('sort_order', $application->sort_order ?? 0) }}">
        @error('sort_order')<div class="small text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3 d-flex align-items-center">
        <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $application->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="is_active">Publikasikan</label>
        </div>
    </div>
</div>

@if(!empty($application->image_path))
    <div class="mb-3 mt-4">
        <label class="form-label fw-semibold">Pratinjau Ikon Saat Ini</label>
        <div class="p-3 border rounded d-flex align-items-center" style="gap: 1rem;">
            <img src="{{ $application->image_url }}" alt="{{ $application->title }}" class="rounded" style="width:120px; height:80px; object-fit:cover;">
            <span class="text-muted small">Unggah berkas baru bila ingin mengganti.</span>
        </div>
    </div>
@endif

<div class="mb-4">
    <label class="form-label fw-semibold">Ikon / Poster (opsional)</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    <small class="text-muted">Rekomendasi rasio landscape 4:3, maksimal 2MB.</small>
    @error('image')<div class="small text-danger">{{ $message }}</div>@enderror
</div>
