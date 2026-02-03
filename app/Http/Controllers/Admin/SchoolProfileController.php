<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Services\MediaService;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class SchoolProfileController extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }

    private function getProfile(): SchoolProfile
    {
        $profile = SchoolProfile::first();

        if (! $profile) {
            $profile = SchoolProfile::create([
                'nama_sekolah' => 'SMP Negeri 4 Samarinda',
                'kepala_sekolah' => 'Kepala Sekolah',
                'alamat' => 'Jl. Juanda No. 123, Samarinda',
                'email' => 'info@smpn4samarinda.sch.id',
                'telepon' => '(0541) 741234',
                'visi' => 'Visi sekolah ditulis di sini.',
                'misi' => 'Misi sekolah ditulis di sini.',
            ]);
        }

        return $profile;
    }

    public function edit()
    {
        $profile = $this->getProfile();

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = $this->getProfile();

        $data = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:50',
            'akreditasi' => 'nullable|string|max:50',
            'kepala_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required|string|max:50',
            'sejarah' => 'nullable|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'tujuan' => 'nullable|string',
            'struktur_organisasi' => 'nullable|string',
            'sambutan_kepsek' => 'nullable|string',
            'maps_embed' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'foto_kepsek' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto_kepsek')) {
            $this->mediaService->delete($profile->foto_kepsek);
            $data['foto_kepsek'] = $this->mediaService->storeImage($request->file('foto_kepsek'), 'kepala-sekolah');
        }

        if ($request->hasFile('logo')) {
            $this->mediaService->delete($profile->logo_path);
            $data['logo_path'] = $this->mediaService->storeImage($request->file('logo'), 'logo-sekolah');

            $faviconPath = $this->mediaService->generateFavicon($data['logo_path']);
            if ($faviconPath) {
                cache()->put('school_profile_favicon', $faviconPath, 3600);
            } else {
                cache()->forget('school_profile_favicon');
            }
        }

        unset($data['logo']);

        $profile->update($data);

    cache()->forget('school_profile_public');

        ActivityLogger::log('profile.updated', 'Memperbarui profil sekolah');

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
