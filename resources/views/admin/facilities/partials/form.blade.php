@php
    $categoryMeta = $categories ?? \App\Models\Facility::categoryMeta();
    $conditionMeta = $conditions ?? \App\Models\Facility::conditionMeta();
@endphp

<div class="mb-3">
    <label class="form-label fw-semibold">Nama Fasilitas</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $facility->nama ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Kategori Sarpras</label>
    <select name="kategori" class="form-select" required>
        @foreach($categoryMeta as $key => $meta)
            <option value="{{ $key }}" @selected(old('kategori', $facility->kategori ?? array_key_first($categoryMeta)) === $key)>
                {{ $meta['label'] }}
            </option>
        @endforeach
    </select>
    <small class="text-muted">Kategori digunakan untuk tab filter di halaman publik.</small>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Jumlah Unit</label>
        <input type="number" name="jumlah" class="form-control" min="0" max="500" value="{{ old('jumlah', $facility->jumlah ?? null) }}" placeholder="cth. 12">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Kondisi</label>
        <select name="kondisi" class="form-select" required>
            @foreach($conditionMeta as $key => $meta)
                <option value="{{ $key }}" @selected(old('kondisi', $facility->kondisi ?? 'baik') === $key)>
                    {{ $meta['label'] }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label fw-semibold">Deskripsi Singkat</label>
    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Paparkan fungsi fasilitas atau catatan perawatan.">{{ old('deskripsi', $facility->deskripsi ?? '') }}</textarea>
</div>

@if(!empty($facility->foto_path))
    <div class="mb-3 text-center">
        <img src="{{ asset('storage/' . $facility->foto_path) }}" class="img-fluid rounded shadow-sm" style="max-height: 220px; object-fit: cover;" alt="Foto {{ $facility->nama }}">
        <div class="small text-muted mt-2">Foto saat ini. Unggah file baru bila ingin mengganti.</div>
    </div>
@endif

<div class="mb-3">
    <label class="form-label fw-semibold">Foto Dokumentasi (opsional)</label>
    <input type="file" name="foto" class="form-control" accept="image/*">
    <small class="text-muted">Format JPG/PNG maksimal 2MB untuk galeri Sarpras publik.</small>
</div>

<div class="form-check form-switch mb-4">
    <input class="form-check-input" type="checkbox" id="status_publish" name="status_publish" value="1" {{ old('status_publish', $facility->status_publish ?? true) ? 'checked' : '' }}>
    <label class="form-check-label fw-semibold" for="status_publish">Tampilkan di halaman Sarpras publik</label>
</div>
