@php
    $oldAttachmentLabels = old('lampiran_labels', []);
    $oldLinkLabels = old('link_labels', []);
    $oldLinkUrls = old('link_urls', []);
    $oldLinkCount = max(count($oldLinkLabels), count($oldLinkUrls));
@endphp

<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="judul" class="form-control" value="{{ old('judul', $ppdb->judul ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control">
        <option value="buka" @selected(old('status', $ppdb->status ?? 'buka') === 'buka')>Buka</option>
        <option value="tutup" @selected(old('status', $ppdb->status ?? 'buka') === 'tutup')>Tutup</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Konten / Pengumuman</label>
    <textarea name="konten" class="form-control wysiwyg-editor" rows="6" placeholder="Tulis pengumuman lengkap di sini">{{ old('konten', $ppdb->konten ?? '') }}</textarea>
</div>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Lampiran (PDF)</h5>
        <small class="text-muted">Ditampilkan hanya saat status dibuka</small>
    </div>
    <p class="text-muted small mb-3">Tambahkan satu atau lebih lampiran dengan keterangan agar calon peserta mudah memahami dokumen yang perlu dibaca.</p>

    @if(!empty($ppdb?->lampiran_items))
        <div class="bg-light rounded p-3 mb-3">
            <div class="fw-semibold text-uppercase small mb-2">Lampiran tersimpan</div>
            @foreach($ppdb->lampiran_items as $idx => $item)
                <div class="border rounded p-3 mb-3">
                    <div class="mb-2">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="existing_attachments[{{ $idx }}][label]" class="form-control" value="{{ old("existing_attachments.$idx.label", $item['label'] ?? 'Lampiran ' . ($loop->iteration)) }}">
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small d-block">File saat ini:</span>
                        <a href="{{ !empty($item['path']) ? asset('storage/' . $item['path']) : '#' }}" target="_blank" rel="noopener">Lihat dokumen</a>
                    </div>
                    <input type="hidden" name="existing_attachments[{{ $idx }}][path]" value="{{ $item['path'] ?? '' }}">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="existing_attachments[{{ $idx }}][delete]" value="1" id="hapusLampiran{{ $idx }}">
                        <label class="form-check-label" for="hapusLampiran{{ $idx }}">Hapus lampiran ini</label>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div id="attachmentRepeater" class="d-flex flex-column gap-3" data-next-index="{{ count($oldAttachmentLabels) }}">
        @foreach($oldAttachmentLabels as $idx => $label)
            <div class="card card-body shadow-sm p-3" data-attachment-row>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Lampiran Baru</h6>
                    <button type="button" class="btn btn-link text-danger text-decoration-none p-0" data-remove-row>&times;</button>
                </div>
                <div class="mb-2">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="lampiran_labels[{{ $idx }}]" class="form-control" value="{{ $label }}" placeholder="Contoh: Panduan Orang Tua">
                </div>
                <div>
                    <label class="form-label">File PDF</label>
                    <input type="file" name="lampiran_files[{{ $idx }}]" class="form-control" accept="application/pdf">
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-outline-secondary btn-sm mt-3" data-add-attachment>Tambah Lampiran</button>
    <small class="text-muted d-block mt-2">Format PDF, maksimum 5 MB per file.</small>
</div>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Link Pendaftaran</h5>
        <small class="text-muted">Tambahkan beberapa link bila diperlukan</small>
    </div>
    <p class="text-muted small mb-3">Setiap link dapat diberi keterangan, misalnya "Formulir Jalur Prestasi" atau "Tutorial Pengisian".</p>

    @if(!empty($ppdb?->link_items))
        <div class="bg-light rounded p-3 mb-3">
            <div class="fw-semibold text-uppercase small mb-2">Link tersimpan</div>
            @foreach($ppdb->link_items as $idx => $item)
                <div class="border rounded p-3 mb-3">
                    <div class="mb-2">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="existing_links[{{ $idx }}][label]" class="form-control" value="{{ old("existing_links.$idx.label", $item['label'] ?? 'Link ' . ($loop->iteration)) }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">URL</label>
                        <input type="url" name="existing_links[{{ $idx }}][url]" class="form-control" value="{{ old("existing_links.$idx.url", $item['url'] ?? '') }}" placeholder="https://">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="existing_links[{{ $idx }}][delete]" value="1" id="hapusLink{{ $idx }}">
                        <label class="form-check-label" for="hapusLink{{ $idx }}">Hapus link ini</label>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div id="linkRepeater" class="d-flex flex-column gap-3" data-next-index="{{ $oldLinkCount }}">
        @for($i = 0; $i < $oldLinkCount; $i++)
            <div class="card card-body shadow-sm p-3" data-link-row>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Link Baru</h6>
                    <button type="button" class="btn btn-link text-danger text-decoration-none p-0" data-remove-row>&times;</button>
                </div>
                <div class="mb-2">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="link_labels[{{ $i }}]" class="form-control" value="{{ $oldLinkLabels[$i] ?? '' }}" placeholder="Contoh: Formulir Jalur Zonasi">
                </div>
                <div>
                    <label class="form-label">URL</label>
                    <input type="url" name="link_urls[{{ $i }}]" class="form-control" value="{{ $oldLinkUrls[$i] ?? '' }}" placeholder="https://">
                </div>
            </div>
        @endfor
    </div>
    <button type="button" class="btn btn-outline-secondary btn-sm mt-3" data-add-link>Tambah Link</button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const attachmentContainer = document.getElementById('attachmentRepeater');
        const linkContainer = document.getElementById('linkRepeater');

        const addAttachmentBtn = document.querySelector('[data-add-attachment]');
        const addLinkBtn = document.querySelector('[data-add-link]');

        const createAttachmentRow = (index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'card card-body shadow-sm p-3';
            wrapper.setAttribute('data-attachment-row', '');
            wrapper.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Lampiran Baru</h6>
                    <button type="button" class="btn btn-link text-danger text-decoration-none p-0" data-remove-row>&times;</button>
                </div>
                <div class="mb-2">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="lampiran_labels[${index}]" class="form-control" placeholder="Contoh: Berkas Persyaratan">
                </div>
                <div>
                    <label class="form-label">File PDF</label>
                    <input type="file" name="lampiran_files[${index}]" class="form-control" accept="application/pdf">
                </div>
            `;
            return wrapper;
        };

        const createLinkRow = (index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'card card-body shadow-sm p-3';
            wrapper.setAttribute('data-link-row', '');
            wrapper.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Link Baru</h6>
                    <button type="button" class="btn btn-link text-danger text-decoration-none p-0" data-remove-row>&times;</button>
                </div>
                <div class="mb-2">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="link_labels[${index}]" class="form-control" placeholder="Contoh: Formulir Jalur Prestasi">
                </div>
                <div>
                    <label class="form-label">URL</label>
                    <input type="url" name="link_urls[${index}]" class="form-control" placeholder="https://">
                </div>
            `;
            return wrapper;
        };

        const handleAddRow = (container, factory, datasetKey) => {
            if (!container) {
                return;
            }

            const nextIndex = Number(container.dataset[datasetKey] || container.children.length);
            container.dataset[datasetKey] = nextIndex + 1;
            container.appendChild(factory(nextIndex));
        };

        addAttachmentBtn?.addEventListener('click', () => {
            handleAddRow(attachmentContainer, createAttachmentRow, 'nextIndex');
        });

        addLinkBtn?.addEventListener('click', () => {
            handleAddRow(linkContainer, createLinkRow, 'nextIndex');
        });

        document.addEventListener('click', (event) => {
            if (!event.target.matches('[data-remove-row]')) {
                return;
            }

            const wrapper = event.target.closest('[data-attachment-row], [data-link-row]');
            wrapper?.remove();
        });
    });
</script>
@endpush
