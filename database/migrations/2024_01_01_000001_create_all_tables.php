<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // 1. Users (Wajib untuk Login Admin)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Sessions (Wajib untuk Laravel 11+)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 3. Password Reset Tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 4. Profil Sekolah
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('SMP Negeri 4 Samarinda');
            $table->string('npsn')->nullable();
            $table->string('akreditasi')->nullable();
            $table->string('kepala_sekolah');
            $table->text('alamat');
            $table->string('email');
            $table->string('telepon');

            // KOLOM LENGKAP SESUAI STANDAR
            $table->text('sejarah')->nullable();
            $table->text('visi');
            $table->text('misi');
            $table->text('tujuan')->nullable();
            $table->string('struktur_organisasi')->nullable();

            $table->text('sambutan_kepsek')->nullable();
            $table->text('maps_embed')->nullable();
            $table->timestamps();
        });

        // 5. Guru
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('jabatan')->nullable();
            $table->enum('jenis', ['pendidik', 'tendik'])->default('pendidik');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // 6. Berita & Pengumuman
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->enum('kategori', ['berita', 'pengumuman', 'agenda', 'prestasi'])->default('berita');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 7. Pengumuman (Opsional, jika dipisah)
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->timestamps();
        });

        // 8. PPDB
        Schema::create('ppdbs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('konten')->nullable();
            $table->enum('status', ['buka', 'tutup']);
            $table->string('link_daftar')->nullable();
            $table->timestamps();
        });

        // 9. Fasilitas
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 10. Pesan Masuk
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->text('pesan');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('ppdbs');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('school_profiles');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
