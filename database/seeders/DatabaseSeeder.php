<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SchoolProfile;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\Facility;
use App\Models\Ppdb;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Admin Account
        $user = User::updateOrCreate(
            ['email' => 'admin@smpn4samarinda.sch.id'],
            [
                'name' => 'Admin SMPN 4',
                'password' => Hash::make('admin123'),
            ]
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
            Facility::create(['nama' => 'Laboratorium Komputer', 'deskripsi' => 'Dilengkapi 40 PC terbaru.']);
            Facility::create(['nama' => 'Perpustakaan', 'deskripsi' => 'Ruang baca nyaman ber-AC.']);
            Facility::create(['nama' => 'Ruang Kelas', 'deskripsi' => 'Kelas yang bersih dan nyaman.']);
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
