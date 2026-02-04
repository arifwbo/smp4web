@php($isEdit = isset($principal))
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center">
                <p class="text-muted small mb-2">Foto Kepala Sekolah</p>
                <div class="rounded-circle bg-light mx-auto mb-3" style="width: 180px; height: 180px; overflow: hidden;">
                    <img src="{{ $isEdit ? $principal->photo_url : asset('img/logo-smp4.jpg') }}" alt="Foto" class="w-100 h-100" style="object-fit: cover;">
                </div>
                <div class="custom-file text-left">
                    <input type="file" class="custom-file-input" id="photo" name="photo">
                    <label class="custom-file-label" for="photo">Pilih foto...</label>
                    <small class="text-muted d-block mt-2">Format jpg/png/webp, maks 4MB.</small>
                    @error('photo')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Kepala Sekolah</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $principal->name ?? '') }}" required>
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Masa Jabatan</label>
                        <input type="text" class="form-control" name="period" placeholder="Misal: 2015-2019" value="{{ old('period', $principal->period ?? '') }}">
                        @error('period')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Urutan Tampil</label>
                        <input type="number" class="form-control" name="sort_order" min="0" max="999" value="{{ old('sort_order', $principal->sort_order ?? '') }}">
                        @error('sort_order')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Catatan Singkat</label>
                    <textarea class="form-control" name="description" rows="5" placeholder="Ringkasan prestasi atau kontribusi..">{{ old('description', $principal->description ?? '') }}</textarea>
                    @error('description')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.former-principals.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary-custom">{{ $isEdit ? 'Perbarui' : 'Simpan' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
