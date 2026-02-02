<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SchoolProfile;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\Facility;
use App\Models\Message;
use App\Models\Curriculum;

class PublicController extends Controller {
    private function getCommonData() {
        return SchoolProfile::first();
    }

    public function index() {
        $profil = $this->getCommonData();
        $berita = Post::where('kategori', 'berita')->latest()->take(3)->get();
        $pengumuman = Post::where('kategori', 'pengumuman')->latest()->take(3)->get();
        $agenda = Post::where('kategori', 'agenda')->latest()->take(3)->get();
        return view('public.home', compact('profil', 'berita', 'pengumuman', 'agenda'));
    }
    public function profil() {
        return view('public.profil', ['profil' => $this->getCommonData()]);
    }
    public function guru() {
        $teachers = Teacher::orderBy('jenis')->orderBy('nama')->get();
        return view('public.guru', ['profil' => $this->getCommonData(), 'teachers' => $teachers]);
    }
    public function sarpras() {
        $facilities = Facility::all();
        return view('public.sarpras', ['profil' => $this->getCommonData(), 'facilities' => $facilities]);
    }
    public function akademik() {
        // Data dummy untuk akademik jika DB belum ada
        return view('public.akademik', ['profil' => $this->getCommonData()]);
    }
    public function ppdb() {
        $ppdbModel = 'App\\Models\\Ppdb';
        $ppdb = class_exists($ppdbModel) ? $ppdbModel::first() : null;
        return view('public.ppdb', ['profil' => $this->getCommonData(), 'ppdb' => $ppdb]);
    }
    public function informasi() {
        $posts = Post::latest()->paginate(10);
        return view('public.informasi', ['profil' => $this->getCommonData(), 'posts' => $posts]);
    }
    public function galeri() {
        $galleryClass = 'App\\Models\\Gallery';
        $galleries = class_exists($galleryClass)
            ? $galleryClass::latest()->get()
            : collect();

        return view('public.galeri', ['profil' => $this->getCommonData(), 'galleries' => $galleries]);
    }
    public function kontak() {
        return view('public.kontak', ['profil' => $this->getCommonData()]);
    }
    public function kirimPesan(Request $request) {
        $data = $request->validate([
            'nama' => 'required', 'email' => 'required|email', 'pesan' => 'required'
        ]);
        Message::create($data);
        return back()->with('success', 'Pesan Anda telah terkirim!');
    }
    public function beritaDetail($slug) {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('public.berita-detail', ['profil' => $this->getCommonData(), 'post' => $post]);
    }
}
