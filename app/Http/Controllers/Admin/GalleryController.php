<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\MediaService;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(private MediaService $media)
    {
    }

    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create', ['gallery' => new Gallery()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['required', 'array', 'min:1'],
            'gambar.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [], [
            'gambar' => 'file gambar',
            'gambar.*' => 'file gambar',
        ]);

        $files = $request->file('gambar', []);

        $created = 0;
        foreach ($files as $index => $file) {
            $entry = [
                'judul' => count($files) > 1
                    ? $validated['judul'] . ' #' . ($index + 1)
                    : $validated['judul'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'gambar' => $this->media->storeImage($file, 'galleries'),
            ];

            Gallery::create($entry);
            $created++;
        }

        if ($created > 0) {
            ActivityLogger::log('gallery.created', "Menambahkan {$created} foto galeri.");
        }

        $message = $created > 1
            ? "{$created} foto galeri berhasil ditambahkan."
            : 'Foto galeri berhasil ditambahkan.';

        return redirect()->route('admin.galleries.index')->with('success', $message);
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $this->validatedData($request, false);

        if ($request->hasFile('gambar')) {
            $this->media->delete($gallery->gambar);
            $data['gambar'] = $this->media->storeImage($request->file('gambar'), 'galleries');
        }

        $gallery->update($data);

        ActivityLogger::log('gallery.updated', 'Memperbarui foto galeri: ' . $gallery->judul);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->media->delete($gallery->gambar);
        $gallery->delete();

        ActivityLogger::log('gallery.deleted', 'Menghapus foto galeri: ' . $gallery->judul);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil dihapus.');
    }

    private function validatedData(Request $request, bool $isCreate = true): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => [$isCreate ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
    }
}
