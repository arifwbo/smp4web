<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['slug' => 'dashboard.view', 'name' => 'Akses Dashboard', 'description' => 'Mengakses panel ringkasan admin'],
            ['slug' => 'users.manage', 'name' => 'Kelola Pengguna', 'description' => 'Menambah, mengubah, menghapus akun pengguna'],
            ['slug' => 'roles.manage', 'name' => 'Kelola Peran & Izin', 'description' => 'Mengatur role dan permission'],
            ['slug' => 'activity.logs.view', 'name' => 'Lihat Log Aktivitas', 'description' => 'Melihat catatan aktivitas'],
            ['slug' => 'activity.logs.delete', 'name' => 'Hapus Log Aktivitas', 'description' => 'Menghapus catatan aktivitas'],
            ['slug' => 'profile.update', 'name' => 'Perbarui Profil Sekolah', 'description' => 'Mengubah teks dan gambar profil sekolah'],
            ['slug' => 'posts.manage', 'name' => 'Kelola Semua Berita', 'description' => 'CRUD seluruh berita & pengumuman'],
            ['slug' => 'posts.academic', 'name' => 'Kelola Berita Akademik', 'description' => 'Kelola konten kategori akademik'],
            ['slug' => 'posts.sarpras', 'name' => 'Kelola Berita Sarpras', 'description' => 'Kelola konten kategori sarpras'],
            ['slug' => 'sliders.manage', 'name' => 'Kelola Slider Beranda', 'description' => 'Menambah dan menyunting slider'],
            ['slug' => 'galleries.manage', 'name' => 'Kelola Galeri Foto', 'description' => 'Mengatur galeri foto dan dokumentasi'],
            ['slug' => 'gallery-videos.manage', 'name' => 'Kelola Galeri Video', 'description' => 'Mengatur daftar video publik'],
            ['slug' => 'messages.view', 'name' => 'Lihat Pesan Masuk', 'description' => 'Membaca pesan dari publik'],
            ['slug' => 'messages.reply', 'name' => 'Balas Pesan Masuk', 'description' => 'Membalas pesan melalui panel admin'],
            ['slug' => 'teachers.manage', 'name' => 'Kelola Data GTK', 'description' => 'Menambah, impor, dan update data GTK'],
            ['slug' => 'academic.manage', 'name' => 'Kelola Halaman Akademik', 'description' => 'Mengedit konten laman akademik'],
            ['slug' => 'ppdb.manage', 'name' => 'Kelola PPDB', 'description' => 'Melihat & memperbarui data PPDB'],
            ['slug' => 'ppdb.export', 'name' => 'Export PPDB', 'description' => 'Mengunduh data pendaftar PPDB'],
            ['slug' => 'facilities.manage', 'name' => 'Kelola Fasilitas', 'description' => 'Mengelola sarana prasarana'],
            ['slug' => 'application-links.manage', 'name' => 'Kelola Portal Aplikasi', 'description' => 'CRUD tautan portal aplikasi'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name'], 'description' => $permission['description']]
            );
        }

        $roles = [
            Role::SUPER_ADMIN => [
                'name' => 'Super Admin',
                'description' => 'Akses penuh semua fitur',
                'is_system' => true,
                'permissions' => 'all',
            ],
            Role::ADMIN_CONTENT => [
                'name' => 'Admin Konten',
                'description' => 'Fokus pada berita, slider, galeri, dan pesan masuk',
                'permissions' => [
                    'dashboard.view',
                    'posts.manage',
                    'sliders.manage',
                    'galleries.manage',
                    'gallery-videos.manage',
                    'messages.view',
                    'messages.reply',
                    'profile.update',
                    'application-links.manage',
                ],
            ],
            Role::ADMIN_AKADEMIK => [
                'name' => 'Admin Akademik',
                'description' => 'Mengelola konten akademik, GTK, dan PPDB',
                'permissions' => [
                    'dashboard.view',
                    'academic.manage',
                    'teachers.manage',
                    'ppdb.manage',
                    'ppdb.export',
                    'posts.academic',
                    'messages.view',
                ],
            ],
            Role::ADMIN_SARPRAS => [
                'name' => 'Admin Sarpras',
                'description' => 'Mengelola fasilitas dan dokumentasi sarpras',
                'permissions' => [
                    'dashboard.view',
                    'facilities.manage',
                    'galleries.manage',
                    'posts.sarpras',
                ],
            ],
            Role::ADMIN_PPDB => [
                'name' => 'Admin PPDB',
                'description' => 'Fokus pada data PPDB',
                'permissions' => [
                    'dashboard.view',
                    'ppdb.manage',
                    'ppdb.export',
                ],
            ],
            Role::VIEWER => [
                'name' => 'Viewer / Monitor',
                'description' => 'Hanya monitoring laporan',
                'permissions' => [
                    'dashboard.view',
                    'activity.logs.view',
                ],
            ],
        ];

        foreach ($roles as $slug => $meta) {
            $role = Role::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $meta['name'],
                    'description' => $meta['description'],
                    'is_system' => $meta['is_system'] ?? false,
                ]
            );

            if ($meta['permissions'] === 'all') {
                $role->permissions()->sync(Permission::pluck('id'));
            } else {
                $permissionIds = Permission::whereIn('slug', $meta['permissions'])->pluck('id');
                $role->permissions()->sync($permissionIds);
            }
        }

        $firstUser = User::query()->oldest()->first();
        if ($firstUser && ! $firstUser->role_id) {
            $superRole = Role::where('slug', Role::SUPER_ADMIN)->first();
            if ($superRole) {
                $firstUser->assignRole($superRole);
            }
        }
    }
}
