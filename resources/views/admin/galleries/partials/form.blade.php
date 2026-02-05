@php $isEdit = isset($gallery) && $gallery->exists; @endphp
<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="judul" class="form-control" value="{{ old('judul', $gallery->judul ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $gallery->deskripsi ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>{{ $isEdit ? 'Ganti Gambar (opsional)' : 'Pilih Gambar' }}</label>
    @if($isEdit)
        <input type="file" name="gambar" class="form-control">
        @if(!empty($gallery?->gambar))
            <small class="text-muted d-block mt-1">Saat ini: {{ $gallery->gambar }}</small>
        @endif
    @else
        <input type="file" name="gambar[]" class="form-control" multiple required>
        <small class="text-muted">Anda dapat memilih lebih dari satu file sekaligus.</small>
    @endif
</div>
