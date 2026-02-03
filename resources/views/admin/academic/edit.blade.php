@extends('layouts.admin')

@section('title', 'Halaman Akademik')
@section('page-title', 'Kelola Konten Akademik')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Halaman Akademik</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @php
        $heroPoints = old('hero_points', $setting->hero_points ?? []);
        $heroPoints = count($heroPoints) ? $heroPoints : [''];

        $supportPoints = old('support_points', $setting->support_points ?? []);
        $supportPoints = count($supportPoints) ? $supportPoints : [''];

        $curriculumHighlights = old('curriculum_highlights', collect($setting->curriculum_highlights ?? [])->map(function ($item) {
            $item['items_text'] = implode("\n", $item['items'] ?? []);
            return $item;
        })->toArray());
        $curriculumHighlights = count($curriculumHighlights) ? $curriculumHighlights : [[]];

        $subjectAllocations = old('subject_allocations', $setting->subject_allocations ?? []);
        $subjectAllocations = count($subjectAllocations) ? $subjectAllocations : [['mapel' => '', 'kelas_vii' => '', 'kelas_viii' => '', 'kelas_ix' => '']];

        $programs = old('programs', collect($setting->programs ?? [])->map(function ($item) {
            $item['tags_text'] = implode("\n", $item['tags'] ?? []);
            return $item;
        })->toArray());
        $programs = count($programs) ? $programs : [[]];

        $extracurriculars = old('extracurriculars', $setting->extracurriculars ?? []);
        $extracurriculars = count($extracurriculars) ? $extracurriculars : [['name' => '', 'desc' => '', 'icon' => '']];

        $timelines = old('timelines', $setting->timelines ?? []);
        $timelines = count($timelines) ? $timelines : [['periode' => '', 'kegiatan' => '']];
    @endphp

    <form method="POST" action="{{ route('admin.academic.update') }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header"><h3 class="card-title">Hero & Highlight</h3></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul Utama</label>
                            <input type="text" name="hero_title" class="form-control @error('hero_title') is-invalid @enderror" value="{{ old('hero_title', $setting->hero_title) }}">
                            @error('hero_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Subjudul</label>
                            <input type="text" name="hero_subtitle" class="form-control @error('hero_subtitle') is-invalid @enderror" value="{{ old('hero_subtitle', $setting->hero_subtitle) }}">
                            @error('hero_subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="hero_description" rows="3" class="form-control @error('hero_description') is-invalid @enderror">{{ old('hero_description', $setting->hero_description) }}</textarea>
                            @error('hero_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Teks Tombol Pendidik</label>
                                <input type="text" name="cta_teacher_label" class="form-control" value="{{ old('cta_teacher_label', $setting->cta_teacher_label ?? 'Tim Pendidik') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Link Tombol Pendidik</label>
                                <input type="url" name="cta_teacher_link" class="form-control" value="{{ old('cta_teacher_link', $setting->cta_teacher_link ?? route('guru')) }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Teks Tombol PPDB</label>
                                <input type="text" name="cta_ppdb_label" class="form-control" value="{{ old('cta_ppdb_label', $setting->cta_ppdb_label ?? 'Info PPDB') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Link Tombol PPDB</label>
                                <input type="url" name="cta_ppdb_link" class="form-control" value="{{ old('cta_ppdb_link', $setting->cta_ppdb_link ?? route('ppdb')) }}">
                            </div>
                        </div>
                        <label class="d-block">Poin Highlight</label>
                        <div id="hero-points" class="mb-3">
                            @foreach($heroPoints as $index => $point)
                                <div class="input-group mb-2">
                                    <input type="text" name="hero_points[{{ $index }}]" class="form-control" value="{{ $point }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger" type="button" data-remove>&times;</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add="hero-points">Tambah Poin</button>
                    </div>
                </div>

                <div class="card card-warning card-outline mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Kartu Kurikulum</h3>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-block data-target="#curriculum-blocks" data-template="curriculum-template">Tambah Kartu</button>
                    </div>
                    <div class="card-body" id="curriculum-blocks">
                        @foreach($curriculumHighlights as $index => $card)
                            <div class="border rounded p-3 mb-3" data-block>
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0">Kartu #{{ $loop->iteration }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Ikon FontAwesome</label>
                                        <input type="text" name="curriculum_highlights[{{ $index }}][icon]" class="form-control" value="{{ $card['icon'] ?? '' }}" placeholder="fa-book">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label>Judul</label>
                                        <input type="text" name="curriculum_highlights[{{ $index }}][title]" class="form-control" value="{{ $card['title'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="curriculum_highlights[{{ $index }}][desc]" rows="2" class="form-control">{{ $card['desc'] ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Poin (pisahkan baris)</label>
                                    <textarea name="curriculum_highlights[{{ $index }}][items_text]" rows="3" class="form-control">{{ $card['items_text'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card card-info card-outline mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Program Unggulan</h3>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-block data-target="#program-blocks" data-template="program-template">Tambah Program</button>
                    </div>
                    <div class="card-body" id="program-blocks">
                        @foreach($programs as $index => $program)
                            <div class="border rounded p-3 mb-3" data-block>
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0">Program #{{ $loop->iteration }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
                                </div>
                                <div class="form-group">
                                    <label>Judul Program</label>
                                    <input type="text" name="programs[{{ $index }}][title]" class="form-control" value="{{ $program['title'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="programs[{{ $index }}][desc]" rows="2" class="form-control">{{ $program['desc'] ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Tag (pisahkan baris)</label>
                                    <textarea name="programs[{{ $index }}][tags_text]" rows="2" class="form-control">{{ $program['tags_text'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card card-secondary card-outline mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Kalender Akademik</h3>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-block data-target="#timeline-blocks" data-template="timeline-template">Tambah Jadwal</button>
                    </div>
                    <div class="card-body" id="timeline-blocks">
                        @foreach($timelines as $index => $timeline)
                            <div class="border rounded p-3 mb-3" data-block>
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0">Periode #{{ $loop->iteration }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label>Periode</label>
                                        <input type="text" name="timelines[{{ $index }}][periode]" class="form-control" value="{{ $timeline['periode'] ?? '' }}">
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label>Kegiatan</label>
                                        <textarea name="timelines[{{ $index }}][kegiatan]" rows="2" class="form-control">{{ $timeline['kegiatan'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-outline card-success mb-4">
                    <div class="card-header"><h3 class="card-title">Pendampingan & Ekstrakurikuler</h3></div>
                    <div class="card-body">
                        <label class="d-block">Poin Pendampingan</label>
                        <div id="support-points" class="mb-3">
                            @foreach($supportPoints as $index => $point)
                                <div class="input-group mb-2">
                                    <input type="text" name="support_points[{{ $index }}]" class="form-control" value="{{ $point }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger" type="button" data-remove>&times;</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mb-4" data-add="support-points">Tambah Poin</button>

                        <h6 class="fw-bold">Ekstrakurikuler</h6>
                        <div id="extracurricular-blocks">
                            @foreach($extracurriculars as $index => $eks)
                                <div class="border rounded p-3 mb-3" data-block>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Ekstra #{{ $loop->iteration }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="extracurriculars[{{ $index }}][name]" class="form-control" value="{{ $eks['name'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="extracurriculars[{{ $index }}][desc]" rows="2" class="form-control">{{ $eks['desc'] ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Ikon FontAwesome</label>
                                        <input type="text" name="extracurriculars[{{ $index }}][icon]" class="form-control" value="{{ $eks['icon'] ?? '' }}" placeholder="fa-robot">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-block data-target="#extracurricular-blocks" data-template="extracurricular-template">Tambah Ekstra</button>
                    </div>
                </div>

                <div class="card card-outline card-dark mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Struktur Jam Pelajaran</h3>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-block data-target="#subject-blocks" data-template="subject-template">Tambah Mapel</button>
                    </div>
                    <div class="card-body" id="subject-blocks">
                        @foreach($subjectAllocations as $index => $subject)
                            <div class="border rounded p-3 mb-3" data-block>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Mapel #{{ $loop->iteration }}</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
                                </div>
                                <div class="form-group">
                                    <label>Nama Mapel</label>
                                    <input type="text" name="subject_allocations[{{ $index }}][mapel]" class="form-control" value="{{ $subject['mapel'] ?? '' }}">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Kelas VII</label>
                                        <input type="text" name="subject_allocations[{{ $index }}][kelas_vii]" class="form-control" value="{{ $subject['kelas_vii'] ?? '' }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Kelas VIII</label>
                                        <input type="text" name="subject_allocations[{{ $index }}][kelas_viii]" class="form-control" value="{{ $subject['kelas_viii'] ?? '' }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Kelas IX</label>
                                        <input type="text" name="subject_allocations[{{ $index }}][kelas_ix]" class="form-control" value="{{ $subject['kelas_ix'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <button type="submit" class="btn btn-warning btn-block"><i class="fas fa-save mr-2"></i>Simpan Konten Akademik</button>
                        <a href="{{ route('akademik') }}" class="btn btn-outline-secondary btn-block mt-2" target="_blank"><i class="fas fa-eye mr-2"></i>Lihat Halaman</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <template id="input-template">
        <div class="input-group mb-2">
            <input type="text" class="form-control" name="__NAME__">
            <div class="input-group-append">
                <button class="btn btn-outline-danger" type="button" data-remove>&times;</button>
            </div>
        </div>
    </template>

    <template id="curriculum-template">
        <div class="border rounded p-3 mb-3" data-block>
            <div class="d-flex justify-content-between mb-2">
                <h6 class="mb-0">Kartu Baru</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Ikon</label>
                    <input type="text" class="form-control" name="curriculum_highlights[__INDEX__][icon]" placeholder="fa-book">
                </div>
                <div class="form-group col-md-8">
                    <label>Judul</label>
                    <input type="text" class="form-control" name="curriculum_highlights[__INDEX__][title]">
                </div>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" rows="2" name="curriculum_highlights[__INDEX__][desc]"></textarea>
            </div>
            <div class="form-group">
                <label>Poin (pisahkan baris)</label>
                <textarea class="form-control" rows="3" name="curriculum_highlights[__INDEX__][items_text]"></textarea>
            </div>
        </div>
    </template>

    <template id="program-template">
        <div class="border rounded p-3 mb-3" data-block>
            <div class="d-flex justify-content-between mb-2">
                <h6 class="mb-0">Program Baru</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
            </div>
            <div class="form-group">
                <label>Judul</label>
                <input type="text" class="form-control" name="programs[__INDEX__][title]">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" rows="2" name="programs[__INDEX__][desc]"></textarea>
            </div>
            <div class="form-group">
                <label>Tag (pisahkan baris)</label>
                <textarea class="form-control" rows="2" name="programs[__INDEX__][tags_text]"></textarea>
            </div>
        </div>
    </template>

    <template id="timeline-template">
        <div class="border rounded p-3 mb-3" data-block>
            <div class="d-flex justify-content-between mb-2">
                <h6 class="mb-0">Periode Baru</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label>Periode</label>
                    <input type="text" class="form-control" name="timelines[__INDEX__][periode]">
                </div>
                <div class="form-group col-md-7">
                    <label>Kegiatan</label>
                    <textarea class="form-control" rows="2" name="timelines[__INDEX__][kegiatan]"></textarea>
                </div>
            </div>
        </div>
    </template>

    <template id="extracurricular-template">
        <div class="border rounded p-3 mb-3" data-block>
            <div class="d-flex justify-content-between mb-2">
                <span>Ekstra Baru</span>
                <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control" name="extracurriculars[__INDEX__][name]">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" rows="2" name="extracurriculars[__INDEX__][desc]"></textarea>
            </div>
            <div class="form-group">
                <label>Ikon</label>
                <input type="text" class="form-control" name="extracurriculars[__INDEX__][icon]" placeholder="fa-robot">
            </div>
        </div>
    </template>

    <template id="subject-template">
        <div class="border rounded p-3 mb-3" data-block>
            <div class="d-flex justify-content-between mb-2">
                <span>Mapel Baru</span>
                <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>&times;</button>
            </div>
            <div class="form-group">
                <label>Nama Mapel</label>
                <input type="text" class="form-control" name="subject_allocations[__INDEX__][mapel]">
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Kelas VII</label>
                    <input type="text" class="form-control" name="subject_allocations[__INDEX__][kelas_vii]">
                </div>
                <div class="form-group col-md-4">
                    <label>Kelas VIII</label>
                    <input type="text" class="form-control" name="subject_allocations[__INDEX__][kelas_viii]">
                </div>
                <div class="form-group col-md-4">
                    <label>Kelas IX</label>
                    <input type="text" class="form-control" name="subject_allocations[__INDEX__][kelas_ix]">
                </div>
            </div>
        </div>
    </template>
@endsection

@push('scripts')
<script>
(function() {
    const addInput = (containerId) => {
        const template = document.getElementById('input-template');
        const clone = template.content.cloneNode(true);
        const container = document.getElementById(containerId);
        const index = container.querySelectorAll('.input-group').length;
        clone.querySelector('input').setAttribute('name', `${containerId === 'hero-points' ? 'hero_points' : 'support_points'}[${index}]`);
        container.appendChild(clone);
    };

    document.querySelectorAll('[data-add]').forEach(btn => {
        btn.addEventListener('click', () => addInput(btn.getAttribute('data-add')));
    });

    document.addEventListener('click', function (e) {
        if (e.target.matches('[data-remove]')) {
            const group = e.target.closest('.input-group');
            if (group) {
                group.remove();
            }
        }
        if (e.target.matches('[data-remove-block]')) {
            const block = e.target.closest('[data-block]');
            if (block) {
                block.remove();
            }
        }
    });

    document.querySelectorAll('[data-add-block]').forEach(button => {
        button.addEventListener('click', () => {
            const target = document.querySelector(button.dataset.target);
            const template = document.getElementById(button.dataset.template);
            if (!target || !template) return;
            const clone = template.innerHTML.replace(/__INDEX__/g, Date.now());
            const wrapper = document.createElement('div');
            wrapper.innerHTML = clone;
            target.appendChild(wrapper.firstElementChild);
        });
    });
})();
</script>
@endpush
