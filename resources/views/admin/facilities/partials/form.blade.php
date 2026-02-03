<div class="mb-3">
    <label>Nama Fasilitas</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $facility->nama ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $facility->deskripsi ?? '') }}</textarea>
</div>
