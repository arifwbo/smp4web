<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\ActivityLogger;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(private MediaService $media)
    {
    }

    public function index(Request $request)
    {
        $sort = $request->string('sort')->lower()->value() ?? 'latest';
        $search = $request->string('search')->trim();
        $category = $request->string('category')->lower()->value() ?? 'all';

        $postsQuery = match ($sort) {
            'oldest' => Post::orderBy('created_at'),
            'title_asc' => Post::orderBy('judul'),
            'title_desc' => Post::orderByDesc('judul'),
            default => Post::latest(),
        };

        if ($search->isNotEmpty()) {
            $postsQuery->where('judul', 'like', '%' . $search->value() . '%');
        }

        if ($category !== 'all') {
            $postsQuery->where('kategori', $category);
        }

        $posts = $postsQuery->paginate(10)->withQueryString();

        $categories = [
            'all' => 'Semua Kategori',
            'berita' => 'Berita',
            'pengumuman' => 'Pengumuman',
            'agenda' => 'Agenda',
            'prestasi' => 'Prestasi',
        ];

        return view('admin.posts.index', [
            'posts' => $posts,
            'currentSort' => $sort,
            'searchQuery' => $search->value(),
            'currentCategory' => $category,
            'categoryOptions' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->media->storeImage($request->file('gambar'), 'posts');
        }

        $post = Post::create($data);

        ActivityLogger::log('post.created', 'Menambahkan berita: ' . $post->judul);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('gambar')) {
            $this->media->delete($post->gambar);
            $data['gambar'] = $this->media->storeImage($request->file('gambar'), 'posts');
        }

        $post->update($data);

        ActivityLogger::log('post.updated', 'Memperbarui berita: ' . $post->judul);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $this->media->delete($post->gambar);

        $post->delete();

        ActivityLogger::log('post.deleted', 'Menghapus berita: ' . $post->judul);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $data = $request->validate([
            'action' => ['required', 'in:delete'],
            'selected' => ['required', 'array'],
            'selected.*' => ['integer', 'exists:posts,id'],
        ]);

        $selectedPosts = Post::whereIn('id', $data['selected'])->get();

        foreach ($selectedPosts as $post) {
            $this->media->delete($post->gambar);
            $post->delete();
        }

        ActivityLogger::log('post.bulk', 'Bulk delete ' . $selectedPosts->count() . ' berita');

        return redirect()->route('admin.posts.index')->with('success', 'Berhasil menghapus ' . $selectedPosts->count() . ' berita.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'kategori' => ['required', 'in:berita,pengumuman,agenda,prestasi'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);
    }
}
