<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="judul" class="form-control" value="{{ old('judul', $gallery->judul ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $gallery->deskripsi ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Gambar</label>
    <input type="file" name="gambar" class="form-control" {{ isset($gallery) && $gallery->exists ? '' : 'required' }}>
    @if(!empty($gallery?->gambar))
        <small class="text-muted">Saat ini: {{ $gallery->gambar }}</small>
    @endif
</div>
