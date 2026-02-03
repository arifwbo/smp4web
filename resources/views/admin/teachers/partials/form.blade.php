<div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $teacher->nama ?? '') }}" required>
</div>
<div class="mb-3">
    <label>NIP</label>
    <input type="text" name="nip" class="form-control" value="{{ old('nip', $teacher->nip ?? '') }}">
</div>
<div class="mb-3">
    <label>Jabatan</label>
    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $teacher->jabatan ?? '') }}">
</div>
<div class="mb-3">
    <label>Jenis</label>
    <select name="jenis" class="form-control" required>
        <option value="pendidik" @selected(old('jenis', $teacher->jenis ?? 'pendidik') === 'pendidik')>Pendidik</option>
        <option value="tendik" @selected(old('jenis', $teacher->jenis ?? 'pendidik') === 'tendik')>Tendik</option>
    </select>
</div>
<div class="mb-3">
    <label>Foto</label>
    <input type="file" name="foto" class="form-control">
    @if(!empty($teacher?->foto))
        <small class="text-muted">File saat ini: {{ $teacher->foto }}</small>
    @endif
</div>
