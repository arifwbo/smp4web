<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\SchoolProfile;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\Facility;
use App\Models\ApplicationLink;
use App\Models\Ppdb;
use App\Models\FormerPrincipal;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(UserRoleStatusSeeder::class);

        // 1. Admin Account
        $superRole = Role::where('slug', Role::SUPER_ADMIN)->first();
        $adminPayload = [
            'name' => 'Admin SMPN 4',
            'password' => Hash::make('admin123'),
            'is_active' => true,
        ];

        if ($superRole) {
            $adminPayload['role'] = $superRole->slug;
            $adminPayload['role_id'] = $superRole->id;
        }

        $user = User::updateOrCreate(
            ['email' => 'admin@smpn4samarinda.sch.id'],
            $adminPayload
        );

        // 2. Profil Sekolah (Lengkap)
        // PERBAIKAN: Menghapus markdown syntax pada URL maps_embed
        if (SchoolProfile::count() == 0) {
            SchoolProfile::create([
                'nama_sekolah' => 'SMP Negeri 4 Samarinda',
                'npsn' => '30401234',
                'akreditasi' => 'A (Unggul)',
                'kepala_sekolah' => 'Dr. H. Contoh Nama, M.Pd',
                'alamat' => 'Jl. Juanda No. 123, Samarinda, Kalimantan Timur',
                'email' => 'info@smpn4samarinda.sch.id',
                'telepon' => '(0541) 741234',
                'sambutan_kepsek' => 'Selamat datang di website resmi kami. Kami berkomitmen mewujudkan generasi berprestasi dan berkarakter.',
                'sejarah' => "SMP Negeri 4 Samarinda didirikan pada tahun 1979 dan mulai beroperasi pada tahun 1980.\n\nSeiring berjalannya waktu, sekolah ini terus berkembang menjadi salah satu sekolah favorit di Samarinda.",
                'visi' => 'Terwujudnya Peserta Didik yang Beriman, Cerdas, Terampil, dan Berbudaya Lingkungan.',
                'misi' => "1. Melaksanakan pembelajaran aktif.\n2. Mengembangkan potensi siswa.\n3. Mewujudkan lingkungan sekolah yang bersih.",
                'tujuan' => "1. Menghasilkan lulusan yang berkualitas.\n2. Meraih prestasi di tingkat nasional.",
                'struktur_organisasi' => null,
                'maps_embed' => '<iframe src="[https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.691712285191!2d117.1471!3d-0.4916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMjknMjkuOCJTIDExN8KwMDgnNDkuNiJF!5e0!3m2!1sen!2sid!4v1625000000000!5m2!1sen!2sid](https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.691712285191!2d117.1471!3d-0.4916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMjknMjkuOCJTIDExN8KwMDgnNDkuNiJF!5e0!3m2!1sen!2sid!4v1625000000000!5m2!1sen!2sid)" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'
            ]);
        }

        // 3. Guru Dummy
        if (Teacher::count() == 0) {
            Teacher::create(['nama' => 'Drs. Ahmad', 'nip' => '19700101', 'jabatan' => 'Guru Matematika', 'jenis' => 'pendidik']);
            Teacher::create(['nama' => 'Siti Aminah, S.Pd', 'nip' => '19850202', 'jabatan' => 'Guru Bahasa Inggris', 'jenis' => 'pendidik']);
            Teacher::create(['nama' => 'Budi Santoso', 'nip' => '-', 'jabatan' => 'Kepala Tata Usaha', 'jenis' => 'tendik']);
        }

        // 4. Fasilitas
        if (Facility::count() == 0) {
            $facilities = [
                [
                    'nama' => 'Laboratorium Komputer Terpadu',
                    'kategori' => 'laboratorium',
                    'deskripsi' => 'Laboratorium multimedia berkapasitas 40 unit PC dengan koneksi internet stabil untuk pembelajaran berbasis TIK.',
                    'jumlah' => 1,
                    'kondisi' => 'baik',
                    'status_publish' => true,
                ],
                [
                    'nama' => 'Laboratorium IPA',
                    'kategori' => 'laboratorium',
                    'deskripsi' => 'Ruang eksperimen fisika, kimia, dan biologi dengan lemari reagen, mikroskop, serta meja praktik tahan bahan kimia.',
                    'jumlah' => 1,
                    'kondisi' => 'cukup',
                    'status_publish' => true,
                ],
                [
                    'nama' => 'Perpustakaan Pusat Literasi',
                    'kategori' => 'perpustakaan',
                    'deskripsi' => 'Ruang baca ber-AC, koleksi 6.000 eksemplar, sudut digital library, dan layanan sirkulasi elektronik.',
                    'jumlah' => 1,
                    'kondisi' => 'baik',
                    'status_publish' => true,
                ],
                [
                    'nama' => 'Ruang Kelas Digital',
                    'kategori' => 'fasilitas-utama',
                    'deskripsi' => '24 ruang belajar dengan panel smart TV, koneksi wifi internal, serta pencahayaan alami yang optimal.',
                    'jumlah' => 24,
                    'kondisi' => 'baik',
                    'status_publish' => true,
                ],
                [
                    'nama' => 'Aula Serbaguna',
                    'kategori' => 'penunjang',
                    'deskripsi' => 'Ruang serbaguna untuk rapat, pentas seni, serta kegiatan karakter dengan kapasitas 400 orang.',
                    'jumlah' => 1,
                    'kondisi' => 'cukup',
                    'status_publish' => true,
                ],
                [
                    'nama' => 'Lapangan Upacara & Olahraga',
                    'kategori' => 'lingkungan',
                    'deskripsi' => 'Area serbaguna untuk upacara, sepak bola mini, dan marching band dengan drainase yang telah diperbarui.',
                    'jumlah' => 1,
                    'kondisi' => 'perlu_perbaikan',
                    'status_publish' => true,
                ],
            ];

            foreach ($facilities as $facility) {
                Facility::create($facility);
            }
        }

        if (ApplicationLink::count() == 0) {
            $portalLinks = [
                [
                    'title' => 'E-Raport SMPN 4',
                    'description' => 'Akses penilaian hasil belajar siswa dan rekap rapat wali kelas.',
                    'link_url' => 'https://eraport.smpn4samarinda.sch.id',
                    'button_label' => 'Masuk E-Raport',
                    'accent_color' => '#0f766e',
                    'sort_order' => 1,
                ],
                [
                    'title' => 'SIM Sarpras',
                    'description' => 'Monitoring inventaris dan permohonan perawatan fasilitas sekolah.',
                    'link_url' => 'https://sarpras.smpn4samarinda.sch.id',
                    'button_label' => 'Buka SIM Sarpras',
                    'accent_color' => '#1d4ed8',
                    'sort_order' => 2,
                ],
                [
                    'title' => 'PPDB Internal',
                    'description' => 'Portal pendataan calon peserta didik jalur prestasi dan afirmasi.',
                    'link_url' => 'https://ppdbinternal.smpn4samarinda.sch.id',
                    'button_label' => 'Daftar PPDB',
                    'accent_color' => '#b45309',
                    'sort_order' => 3,
                ],
            ];

            foreach ($portalLinks as $link) {
                ApplicationLink::create($link);
            }
        }

        // 5. PPDB Info
        // PERBAIKAN: Menghapus markdown syntax pada link_daftar
        if (Ppdb::count() == 0) {
            Ppdb::create([
                'judul' => 'PPDB Jalur Zonasi 2025',
                'konten' => 'Pendaftaran dibuka mulai 1 Juli. Syarat: KK Asli, Akta Kelahiran.',
                'status' => 'buka',
                'link_daftar' => 'https://forms.google.com/example',
            ]);
        }

        if (FormerPrincipal::count() == 0) {
            FormerPrincipal::insert([
                [
                    'name' => 'Drs. H. Muhammad Rahman',
                    'period' => '1995 - 2002',
                    'description' => 'Mengawali program Adiwiyata dan penguatan karakter siswa.',
                    'sort_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Dra. Hj. Siti Norhayati',
                    'period' => '2002 - 2010',
                    'description' => 'Berhasil meraih akreditasi A dan memperluas fasilitas laboratorium.',
                    'sort_order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'H. Surya Nugraha, M.Pd',
                    'period' => '2010 - 2018',
                    'description' => 'Fokus pada inovasi pembelajaran berbasis teknologi dan prestasi akademik.',
                    'sort_order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // 6. Berita Dummy
        if (Post::count() == 0) {
            Post::create([
                'judul' => 'Juara 1 Lomba Sains Kota Samarinda',
                'isi' => 'Siswa SMPN 4 kembali menorehkan prestasi...',
                'kategori' => 'berita',
                'user_id' => $user->id
            ]);
            Post::create([
                'judul' => 'Jadwal Libur Semester Ganjil',
                'isi' => 'Diberitahukan kepada seluruh siswa...',
                'kategori' => 'pengumuman',
                'user_id' => $user->id
            ]);
            Post::create([
                'judul' => 'Agenda Rapat Guru',
                'isi' => 'Rapat evaluasi bulanan akan diadakan...',
                'kategori' => 'agenda',
                'user_id' => $user->id
            ]);
        }
    }
}
