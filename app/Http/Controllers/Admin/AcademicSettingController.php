<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSetting;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class AcademicSettingController extends Controller
{
    public function edit()
    {
        $setting = AcademicSetting::first();

        if (! $setting) {
            $setting = AcademicSetting::create([
                'hero_title' => 'Ekosistem Belajar Unggul',
                'hero_subtitle' => 'Program Akademik',
                'hero_description' => 'Kami menerapkan Kurikulum Merdeka dengan kombinasi pembelajaran berbasis proyek dan asesmen autentik.',
                'hero_points' => [
                    'Integrasi Proyek Profil Pelajar Pancasila',
                    'Laboratorium sains, komputer, dan bahasa',
                    'Monitoring belajar berbasis aplikasi',
                ],
                'support_points' => [
                    'Klinik Matematika & Literasi membaca',
                    'Tryout Asesmen Nasional Berbasis Komputer',
                    'Konseling belajar personal untuk kelas IX',
                ],
            ]);
        }

        return view('admin.academic.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = AcademicSetting::firstOrCreate([]);

        $data = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'cta_teacher_label' => 'nullable|string|max:100',
            'cta_teacher_link' => 'nullable|url|max:255',
            'cta_ppdb_label' => 'nullable|string|max:100',
            'cta_ppdb_link' => 'nullable|url|max:255',
            'hero_points' => 'nullable|array',
            'hero_points.*' => 'nullable|string|max:255',
            'support_points' => 'nullable|array',
            'support_points.*' => 'nullable|string|max:255',
            'curriculum_highlights' => 'nullable|array',
            'curriculum_highlights.*.icon' => 'nullable|string|max:50',
            'curriculum_highlights.*.title' => 'nullable|string|max:255',
            'curriculum_highlights.*.desc' => 'nullable|string',
            'curriculum_highlights.*.items_text' => 'nullable|string',
            'subject_allocations' => 'nullable|array',
            'subject_allocations.*.mapel' => 'nullable|string|max:255',
            'subject_allocations.*.kelas_vii' => 'nullable|string|max:50',
            'subject_allocations.*.kelas_viii' => 'nullable|string|max:50',
            'subject_allocations.*.kelas_ix' => 'nullable|string|max:50',
            'programs' => 'nullable|array',
            'programs.*.title' => 'nullable|string|max:255',
            'programs.*.desc' => 'nullable|string',
            'programs.*.tags_text' => 'nullable|string',
            'extracurriculars' => 'nullable|array',
            'extracurriculars.*.name' => 'nullable|string|max:255',
            'extracurriculars.*.desc' => 'nullable|string',
            'extracurriculars.*.icon' => 'nullable|string|max:50',
            'timelines' => 'nullable|array',
            'timelines.*.periode' => 'nullable|string|max:255',
            'timelines.*.kegiatan' => 'nullable|string',
        ]);

        $data['hero_points'] = $this->normalizeList($request->input('hero_points', []));
        $data['support_points'] = $this->normalizeList($request->input('support_points', []));
        $data['curriculum_highlights'] = $this->normalizeHighlights($request->input('curriculum_highlights', []));
        $data['subject_allocations'] = $this->normalizeStructured($request->input('subject_allocations', []));
        $data['programs'] = $this->normalizePrograms($request->input('programs', []));
        $data['extracurriculars'] = $this->normalizeStructured($request->input('extracurriculars', []));
        $data['timelines'] = $this->normalizeStructured($request->input('timelines', []));

        $setting->update($data);

        ActivityLogger::log('academic.updated', 'Memperbarui konten halaman akademik');

        cache()->forget('academic_page');

        return back()->with('success', 'Konten akademik berhasil diperbarui.');
    }

    private function normalizeList(array $items): array
    {
        return collect($items)
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    private function normalizeStructured(array $items): array
    {
        return collect($items)
            ->map(function ($item) {
                return array_filter($item, fn ($value) => $value !== null && $value !== '');
            })
            ->filter()
            ->values()
            ->all();
    }

    private function normalizeHighlights(array $items): array
    {
        return collect($items)
            ->map(function ($item) {
                $item['items'] = $this->splitLines($item['items_text'] ?? '');
                unset($item['items_text']);

                return array_filter($item, fn ($value) => $value !== null && $value !== '' && $value !== []);
            })
            ->filter()
            ->values()
            ->all();
    }

    private function normalizePrograms(array $items): array
    {
        return collect($items)
            ->map(function ($item) {
                $item['tags'] = $this->splitLines($item['tags_text'] ?? '');
                unset($item['tags_text']);

                return array_filter($item, fn ($value) => $value !== null && $value !== '' && $value !== []);
            })
            ->filter()
            ->values()
            ->all();
    }

    private function splitLines(?string $value): array
    {
        return collect(preg_split('/\r?\n/', (string) $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
