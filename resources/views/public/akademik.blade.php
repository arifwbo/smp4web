@extends('layouts.app')

@section('content')
@php
    $heroTitle = $setting->hero_title ?? 'Ekosistem Belajar ' . ($profil->nama_sekolah ?? 'Sekolah Kami');
    $heroSubtitle = $setting->hero_subtitle ?? 'Program Akademik';
    $heroDescription = $setting->hero_description ?? 'Kami menerapkan Kurikulum Merdeka dengan kombinasi pembelajaran berbasis proyek, asesmen autentik, dan dukungan teknologi untuk menumbuhkan kompetensi abad 21.';
    $heroPoints = $setting->hero_points ?? [
        'Integrasi Proyek Profil Pelajar Pancasila',
        'Laboratorium sains, komputer, dan bahasa',
        'Monitoring belajar berbasis aplikasi',
    ];
    $heroPoints = count($heroPoints) ? $heroPoints : ['Highlight pembelajaran aktif'];

    $ctaTeacherLabel = $setting->cta_teacher_label ?? 'Tim Pendidik';
    $ctaTeacherLink = $setting->cta_teacher_link ?? route('guru');
    $ctaPpdbLabel = $setting->cta_ppdb_label ?? 'Info PPDB';
    $ctaPpdbLink = $setting->cta_ppdb_link ?? route('ppdb');

    $curriculumHighlight = $setting->curriculum_highlights ?? [
        [
            'icon' => 'fa-book-open-reader',
            'title' => 'Kurikulum Merdeka',
            'desc' => 'Pembelajaran berdiferensiasi yang memberi ruang eksplorasi minat dan karakter peserta didik.',
            'items' => ['CP & TP setiap fase', 'Proyek P5 lintas tema', 'Penilaian formatif berkelanjutan'],
        ],
    ];

    $strukturMapel = $setting->subject_allocations ?? [
        ['mapel' => 'IPA Terpadu', 'kelas_vii' => '5 JP', 'kelas_viii' => '5 JP', 'kelas_ix' => '6 JP'],
        ['mapel' => 'Matematika', 'kelas_vii' => '5 JP', 'kelas_viii' => '5 JP', 'kelas_ix' => '5 JP'],
    ];

    $supportPoints = $setting->support_points ?? [
        'Klinik Matematika & Literasi membaca',
        'Tryout Asesmen Nasional Berbasis Komputer',
        'Konseling belajar personal untuk kelas IX',
    ];

    $programUnggulan = $setting->programs ?? [
        [
            'title' => 'Program Literasi Digital',
            'desc' => 'Integrasi coding dasar, literasi media, serta keamanan siber untuk siswa kelas VII-IX.',
            'tags' => ['Coding', 'Literasi Media'],
        ],
    ];

    $ekstrakurikuler = $setting->extracurriculars ?? [
        ['name' => 'Pramuka', 'desc' => 'Wajib bagi seluruh peserta didik sebagai pembentuk karakter Pancasila.', 'icon' => 'fa-compass']
    ];

    $kalenderAkademik = $setting->timelines ?? [
        ['periode' => 'Juli - Agustus', 'kegiatan' => 'Masa Pengenalan Lingkungan Sekolah, penetapan projek P5 pertama.'],
    ];
@endphp

<section class="py-5 position-relative" style="background: radial-gradient(circle at top, #0d3b66, #031726);">
    <div class="container py-4">
        <div class="row align-items-center text-white">
            <div class="col-lg-7">
                <p class="text-uppercase fw-semibold text-warning mb-2">{{ $heroSubtitle }}</p>
                <h1 class="display-5 fw-bold mb-3">{{ $heroTitle }}</h1>
                <p class="lead text-white-50 mb-4">{{ $heroDescription }}</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ $ctaTeacherLink }}" class="btn btn-warning text-dark fw-bold px-4 rounded-pill shadow">{{ $ctaTeacherLabel }}</a>
                    <a href="{{ $ctaPpdbLink }}" class="btn btn-outline-light fw-bold px-4 rounded-pill">{{ $ctaPpdbLabel }}</a>
                </div>
            </div>
            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="bg-white bg-opacity-10 rounded-4 p-4 border border-white border-opacity-25">
                    <h5 class="text-uppercase text-warning">Highlight</h5>
                    <ul class="list-unstyled mb-0 text-white-50">
                        @foreach($heroPoints as $point)
                            <li class="py-2"><i class="fa-solid fa-circle-check text-success me-2"></i> {{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary-custom">Fondasi Kurikulum</h2>
            <p class="text-muted">Pendekatan pembelajaran yang menumbuhkan karakter, kompetensi, dan budaya kolaboratif.</p>
        </div>
        <div class="row g-4">
            @foreach($curriculumHighlight as $item)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="rounded-circle bg-primary-custom bg-opacity-10 text-primary-custom d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px;">
                                <i class="fa-solid {{ $item['icon'] }} fa-lg"></i>
                            </div>
                            <h5 class="fw-bold">{{ $item['title'] }}</h5>
                            <p class="text-muted small">{{ $item['desc'] }}</p>
                            <ul class="list-unstyled small text-muted">
                                @foreach(($item['items'] ?? []) as $point)
                                    <li class="mb-1"><i class="fa-solid fa-check text-success me-2"></i>{{ $point }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row align-items-start g-4">
            <div class="col-lg-6">
                <h3 class="fw-bold text-primary-custom mb-3">Struktur Jam Pelajaran</h3>
                <p class="text-muted">Distribusi jam pelajaran mengikuti ketentuan Kemendikbudristek serta kebutuhan lokal sekolah.</p>
                <div class="table-responsive rounded-4 shadow-sm">
                    <table class="table table-bordered mb-0 align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Kelas VII</th>
                                <th>Kelas VIII</th>
                                <th>Kelas IX</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($strukturMapel as $row)
                                <tr>
                                    <td>{{ $row['mapel'] ?? '' }}</td>
                                    <td>{{ $row['kelas_vii'] ?? '' }}</td>
                                    <td>{{ $row['kelas_viii'] ?? '' }}</td>
                                    <td>{{ $row['kelas_ix'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4 rounded-4 bg-primary-custom text-white h-100">
                    <h4 class="fw-bold mb-3">Pendampingan Akademik</h4>
                    <p class="text-white-50">Selain pembelajaran di kelas, siswa mendapatkan program penguatan berikut:</p>
                    <ul class="list-unstyled mb-4">
                        @foreach($supportPoints as $point)
                            <li class="mb-2"><i class="fa-solid fa-star text-warning me-2"></i> {{ $point }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('kontak') }}" class="btn btn-light text-primary-custom fw-semibold rounded-pill">Konsultasi Orang Tua</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Program Unggulan</h2>
            <p class="text-muted">Rangkaian program yang dirancang untuk memaksimalkan potensi akademik dan karakter.</p>
        </div>
        <div class="row g-4">
            @foreach($programUnggulan as $program)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">{{ $program['title'] ?? '' }}</h5>
                            <p class="text-muted small">{{ $program['desc'] ?? '' }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(($program['tags'] ?? []) as $tag)
                                    <span class="badge rounded-pill text-bg-warning text-dark">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <h3 class="fw-bold text-primary-custom mb-4">Ekstrakurikuler Akademik</h3>
                <div class="row g-3">
                    @foreach($ekstrakurikuler as $eks)
                        <div class="col-sm-6">
                            <div class="border rounded-4 p-3 h-100">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-2" style="width:48px;height:48px;">
                                    <i class="fa-solid {{ $eks['icon'] ?? 'fa-star' }} text-primary-custom"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $eks['name'] ?? '' }}</h6>
                                <p class="text-muted small mb-0">{{ $eks['desc'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="fw-bold text-primary-custom mb-4">Kalender Akademik</h3>
                <div class="timeline">
                    @foreach($kalenderAkademik as $item)
                        <div class="timeline-item mb-4 d-flex">
                            <div class="me-3 text-center">
                                <span class="badge bg-primary-custom">{{ $item['periode'] ?? '' }}</span>
                            </div>
                            <div class="flex-grow-1 border-start ps-3">
                                <p class="mb-0 text-muted">{{ $item['kegiatan'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="alert alert-info mt-4 mb-0">
                    Kalender detail dibagikan melalui wali kelas dan dapat diunduh pada aplikasi e-learning sekolah.
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
