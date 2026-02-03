<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="judul" class="form-control" value="{{ old('judul', $ppdb->judul ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="buka" @selected(old('status', $ppdb->status ?? 'buka') === 'buka')>Buka</option>
        <option value="tutup" @selected(old('status', $ppdb->status ?? 'buka') === 'tutup')>Tutup</option>
    </select>
</div>
<div class="mb-3">
    <label>Link Pendaftaran</label>
    <input type="url" name="link_daftar" class="form-control" value="{{ old('link_daftar', $ppdb->link_daftar ?? '') }}">
</div>
<div class="mb-3">
    <label>Konten</label>
    <textarea name="konten" class="form-control" rows="5">{{ old('konten', $ppdb->konten ?? '') }}</textarea>
</div>
