@csrf
<div class="form-group">
    <label>Judul Video</label>
    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $video->judul ?? '') }}" required>
    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-group">
    <label>Deskripsi Singkat</label>
    <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Opsional">{{ old('deskripsi', $video->deskripsi ?? '') }}</textarea>
    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-group">
    <label>URL YouTube</label>
    <input type="url" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror" placeholder="https://www.youtube.com/watch?v=xxxx" value="{{ old('youtube_url', $video->youtube_url ?? '') }}" required>
    @error('youtube_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <small class="form-text text-muted">Masukkan tautan lengkap YouTube (watch, share, embed, atau shorts).</small>
</div>
@if(!empty($video?->youtube_id))
<div class="form-group">
    <label>Pratinjau</label>
    <div class="ratio ratio-16x9">
        <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}" title="Preview YouTube" frameborder="0" allowfullscreen></iframe>
    </div>
</div>
@endif
<button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Simpan</button>
<a href="{{ route('admin.gallery-videos.index') }}" class="btn btn-outline-secondary ml-2">Batal</a>
