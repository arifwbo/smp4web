<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AcademicSetting;
use App\Models\ApplicationLink;
use App\Models\Facility;
use App\Models\FormerPrincipal;
use App\Models\Gallery;
use App\Models\GalleryVideo;
use App\Models\HomeSlider;
use App\Models\Message;
use App\Models\Post;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\ContactMessageNotification;

class PublicController extends Controller {
    private function getCommonData() {
        return SchoolProfile::first();
    }

    public function index() {
        $profil = $this->getCommonData();
        $berita = Post::where('kategori', 'berita')->latest()->take(4)->get();
        $pengumuman = Post::where('kategori', 'pengumuman')->latest()->take(3)->get();
        $latestPengumuman = $pengumuman->first();
        $agenda = Post::where('kategori', 'agenda')->latest()->take(3)->get();
        $featuredTeachers = Teacher::inRandomOrder()->take(9)->get();

        $cachedSlides = cache()->remember('home_sliders', 60, function () {
            return HomeSlider::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(function (HomeSlider $slider) {
                    return [
                        'title' => $slider->title ?? 'SMP Negeri 4 Samarinda',
                        'subtitle' => $slider->subtitle,
                        'button_label' => $slider->button_label,
                        'button_link' => $slider->button_link,
                        'image_url' => $slider->image_path ? asset('storage/' . $slider->image_path) : asset('img/logo-smp4.jpg'),
                    ];
                });
        });

        $fallbackSlides = collect([
            [
                'title' => "Selamat Datang di\nSMP Negeri 4 Samarinda",
                'subtitle' => 'Mewujudkan Generasi Berprestasi, Berkarakter, dan Berwawasan Lingkungan.',
                'button_label' => 'Profil Sekolah',
                'button_link' => route('profil'),
                'image_url' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1920',
            ],
            [
                'title' => "Pembelajaran Aktif &\nMenyenangkan",
                'subtitle' => 'Didukung fasilitas lengkap dan tenaga pengajar profesional.',
                'button_label' => null,
                'button_link' => null,
                'image_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1920',
            ],
            [
                'title' => "Raih Prestasi\nGemilang",
                'subtitle' => 'Mengembangkan potensi siswa baik akademik maupun non-akademik.',
                'button_label' => null,
                'button_link' => null,
                'image_url' => 'https://images.unsplash.com/photo-1577896337318-2838d43f6c6d?q=80&w=1920',
            ],
        ]);

        $slides = $cachedSlides->isNotEmpty() ? $cachedSlides : $fallbackSlides;
        $latestVideos = GalleryVideo::latest()->take(3)->get();
        $latestPhotos = Gallery::inRandomOrder()->take(16)->get();

        $totalTeachersCount = Teacher::count();
        $totalFacilitiesCount = Facility::count();
        $totalPrestasiCount = Post::where('kategori', 'prestasi')->count();
        
        $stats = [
            'students' => $profil?->jumlah_siswa ?? 850,
            'teachers' => $totalTeachersCount > 0 ? $totalTeachersCount : 45,
            'prestasi' => $totalPrestasiCount > 0 ? $totalPrestasiCount : 120,
            'facilities' => $totalFacilitiesCount > 0 ? $totalFacilitiesCount : 24,
        ];

        return view('public.home', compact('profil', 'berita', 'pengumuman', 'latestPengumuman', 'agenda', 'slides', 'featuredTeachers', 'latestVideos', 'latestPhotos', 'stats'));
    }
    public function profil() {
        $formerPrincipals = FormerPrincipal::orderBy('sort_order')->orderByDesc('id')->get();
        $profil = $this->getCommonData();

        $guruStructureFields = [
            'pimpinan_manajemen' => 'Pimpinan & Manajemen',
            'komite_sekolah' => 'Komite Sekolah',
            'kepala_sekolah' => 'Kepala Sekolah',
            'waka_kerjasama' => 'Waka Bidang Manajemen Kerjasama & Kehumasan',
            'waka_kurikulum' => 'Waka Bidang Kurikulum',
            'waka_sarpras' => 'Waka Bidang Sarana Prasarana',
            'waka_kesiswaan' => 'Waka Bidang Kesiswaan',
        ];

        $tuStructureFields = [
            'staf_tata_usaha' => 'Staf Tata Usaha',
            'koordinator_media_bosda' => 'Koordinator Ruang Media & Bendahara BOSDA',
            'bendahara_barang' => 'Bendahara Barang',
            'bendahara_bosp' => 'Bendahara BOSP',
            'kepegawaian' => 'Kepegawaian',
            'pengantar_surat_kesiswaan' => 'Pengantar Surat / Kesiswaan',
            'sapras_surat_menyurat' => 'Sapras / Surat Menyurat',
            'operator_dapodik_kesiswaan' => 'Operator Dapodik / Kesiswaan',
            'staf_kepsek_kurikulum' => 'Staf Kepala Sekolah dan Kurikulum',
            'perpustakaan' => 'Perpustakaan',
            'lab_komputer_teknisi' => 'Lab. Komputer dan Teknisi',
            'laboratorium_ipa' => 'Laboratorium IPA',
            'petugas_kebersihan' => 'Petugas Kebersihan',
            'petugas_taman_kebersihan' => 'Petugas Taman & Kebersihan',
            'petugas_keamanan' => 'Petugas Keamanan Sekolah',
            'penjaga_malam' => 'Penjaga Malam',
        ];

        $guruStructureTable = collect($guruStructureFields)
            ->map(function (string $label, string $key) use ($profil) {
                $value = data_get($profil?->struktur_guru ?? [], $key);

                if (! filled($value)) {
                    return null;
                }

                return [
                    'label' => $label,
                    'value' => $value,
                ];
            })
            ->filter()
            ->values();

        $tuStructureTable = collect($tuStructureFields)
            ->map(function (string $label, string $key) use ($profil) {
                $value = data_get($profil?->struktur_tu ?? [], $key);

                if (! filled($value)) {
                    return null;
                }

                return [
                    'label' => $label,
                    'value' => $value,
                ];
            })
            ->filter()
            ->values();

        return view('public.profil', [
            'profil' => $profil,
            'formerPrincipals' => $formerPrincipals,
            'guruStructureTable' => $guruStructureTable,
            'tuStructureTable' => $tuStructureTable,
        ]);
    }
    public function guru() {
        $teachers = Teacher::orderBy('jenis')->orderBy('nama')->get();
        return view('public.guru', ['profil' => $this->getCommonData(), 'teachers' => $teachers]);
    }
    public function sarpras(Request $request) {
        $profil = $this->getCommonData();
        $categoryMeta = Facility::categoryMeta();
        $conditionMeta = Facility::conditionMeta();

        $activeCategory = strtolower($request->query('kategori', 'semua'));
        if ($activeCategory !== 'semua' && ! array_key_exists($activeCategory, $categoryMeta)) {
            $activeCategory = 'semua';
        }

        $allFacilities = Facility::published()
            ->orderBy('kategori')
            ->orderBy('nama')
            ->get();

        $filteredFacilities = $activeCategory === 'semua'
            ? $allFacilities
            : $allFacilities->where('kategori', $activeCategory);

        $categoryCounts = [];
        foreach ($categoryMeta as $key => $meta) {
            $categoryCounts[$key] = $allFacilities->where('kategori', $key)->count();
        }
        $categoryCounts['semua'] = $allFacilities->count();

        $conditionStats = [
            'baik' => $allFacilities->where('kondisi', 'baik')->count(),
            'cukup' => $allFacilities->where('kondisi', 'cukup')->count(),
            'perlu_perbaikan' => $allFacilities->where('kondisi', 'perlu_perbaikan')->count(),
        ];

        $galleryFacilities = $allFacilities->filter(fn (Facility $facility) => filled($facility->foto_path))->take(8);
        $recentSnapshots = Facility::published()->latest()->take(4)->get();

        return view('public.sarpras', [
            'profil' => $profil,
            'facilities' => $filteredFacilities,
            'categoryMeta' => $categoryMeta,
            'conditionMeta' => $conditionMeta,
            'categoryCounts' => $categoryCounts,
            'conditionStats' => $conditionStats,
            'activeCategory' => $activeCategory,
            'galleryFacilities' => $galleryFacilities,
            'recentSnapshots' => $recentSnapshots,
        ]);
    }

    public function aplikasi()
    {
        $profil = $this->getCommonData();
        $applications = ApplicationLink::active()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $metrics = [
            'total' => $applications->count(),
            'withMedia' => $applications->whereNotNull('image_path')->count(),
            'recentlyUpdated' => optional($applications->sortByDesc('updated_at')->first())->updated_at,
        ];

        $featured = $applications->first();

        return view('public.aplikasi', [
            'profil' => $profil,
            'applications' => $applications,
            'metrics' => $metrics,
            'featured' => $featured,
        ]);
    }
    public function akademik() {
        $setting = cache()->remember('academic_page', 60, fn () => AcademicSetting::first());

        return view('public.akademik', [
            'profil' => $this->getCommonData(),
            'setting' => $setting,
        ]);
    }
    public function ppdb() {
        $ppdbModel = 'App\\Models\\Ppdb';
        $ppdb = class_exists($ppdbModel) ? $ppdbModel::first() : null;
        return view('public.ppdb', ['profil' => $this->getCommonData(), 'ppdb' => $ppdb]);
    }
    public function informasi(Request $request) {
        $profil = $this->getCommonData();
        $categories = ['berita', 'informasi', 'pengumuman', 'agenda'];
        $validFilters = array_merge(['semua'], $categories);
        $activeCategory = strtolower($request->query('kategori', 'semua'));

        if (! in_array($activeCategory, $validFilters, true)) {
            $activeCategory = 'semua';
        }

        $postsQuery = Post::query()->latest();
        if ($activeCategory === 'semua') {
            $postsQuery->whereIn('kategori', $categories);
        } else {
            $postsQuery->where('kategori', $activeCategory);
        }

        $posts = $postsQuery->paginate(9)->withQueryString();

        $countsRaw = Post::selectRaw('kategori, COUNT(*) as total')
            ->whereIn('kategori', $categories)
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $categoryCounts = [];
        foreach ($categories as $category) {
            $categoryCounts[$category] = $countsRaw->get($category, 0);
        }

        $groupedPosts = collect($categories)->mapWithKeys(function ($category) {
            return [$category => Post::where('kategori', $category)->latest()->take(4)->get()];
        });

        return view('public.informasi', [
            'profil' => $profil,
            'posts' => $posts,
            'activeCategory' => $activeCategory,
            'categoryCounts' => $categoryCounts,
            'groupedPosts' => $groupedPosts,
        ]);
    }
    public function galeri() {
        $galleries = Gallery::latest()->paginate(12);
        $videos = GalleryVideo::latest()->take(8)->get();
        return view('public.galeri', ['profil' => $this->getCommonData(), 'galleries' => $galleries, 'videos' => $videos]);
    }
    public function kontak() {
        return view('public.kontak', ['profil' => $this->getCommonData()]);
    }
    public function kirimPesan(Request $request) {
        $data = $request->validate([
            'nama' => 'required', 'email' => 'required|email', 'pesan' => 'required'
        ]);
        $message = Message::create($data);

        $admin = User::where('role', User::ROLE_ADMIN)->first();
        if ($admin) {
            $admin->notify(new ContactMessageNotification($message));
        }

        return back()->with('success', 'Pesan Anda telah terkirim!');
    }
    public function beritaDetail($slug) {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('public.berita-detail', ['profil' => $this->getCommonData(), 'post' => $post]);
    }
}
