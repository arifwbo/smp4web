<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    public function index() {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }
    public function create() {
        return view('admin.posts.create');
    }
    public function store(Request $request) {
        $data = $request->validate(['judul'=>'required', 'isi'=>'required', 'kategori'=>'required']);
        $data['user_id'] = Auth::id();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('posts', 'public');
        }
        Post::create($data);
        return redirect()->route('admin.posts.index');
    }
}
