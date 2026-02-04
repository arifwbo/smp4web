<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryVideo;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GalleryVideoController extends Controller
{
    public function index()
    {
        $videos = GalleryVideo::latest()->paginate(12);

        return view('admin.gallery-videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.gallery-videos.create', ['video' => new GalleryVideo()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $video = GalleryVideo::create($data);

        ActivityLogger::log('gallery_video.created', 'Menambah video galeri: ' . $video->judul);

        return redirect()->route('admin.gallery-videos.index')->with('success', 'Video galeri berhasil ditambahkan.');
    }

    public function edit(GalleryVideo $galleryVideo)
    {
        return view('admin.gallery-videos.edit', ['video' => $galleryVideo]);
    }

    public function update(Request $request, GalleryVideo $galleryVideo)
    {
        $data = $this->validatedData($request);
        $galleryVideo->update($data);

        ActivityLogger::log('gallery_video.updated', 'Memperbarui video galeri: ' . $galleryVideo->judul);

        return redirect()->route('admin.gallery-videos.index')->with('success', 'Video galeri berhasil diperbarui.');
    }

    public function destroy(GalleryVideo $galleryVideo)
    {
        $galleryVideo->delete();

        ActivityLogger::log('gallery_video.deleted', 'Menghapus video galeri: ' . $galleryVideo->judul);

        return redirect()->route('admin.gallery-videos.index')->with('success', 'Video galeri berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'youtube_url' => ['required', 'url', 'max:255'],
        ]);

        $youtubeId = $this->extractYoutubeId($data['youtube_url']);

        if (! $youtubeId) {
            throw ValidationException::withMessages([
                'youtube_url' => 'URL YouTube tidak valid atau tidak dapat diproses.',
            ]);
        }

        $data['youtube_id'] = $youtubeId;

        return $data;
    }

    private function extractYoutubeId(string $url): ?string
    {
        $patterns = [
            '#youtu\\.be/([^?&/]+)#',
            '#youtube\\.com/shorts/([^?&/]+)#',
            '#youtube\\.com/embed/([^?&/]+)#',
            '#youtube\\.com/watch\\?v=([^?&/]+)#',
            '#youtube\\.com/watch\\?.*?&v=([^?&/]+)#',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        $parsed = parse_url($url);
        if (($parsed['host'] ?? '') === 'youtu.be' && isset($parsed['path'])) {
            return ltrim($parsed['path'], '/');
        }

        parse_str($parsed['query'] ?? '', $query);
        if (isset($query['v'])) {
            return $query['v'];
        }

        return null;
    }
}
