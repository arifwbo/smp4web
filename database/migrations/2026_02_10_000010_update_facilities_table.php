<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->string('kategori', 100)->default('fasilitas-utama')->after('nama');
            $table->unsignedSmallInteger('jumlah')->nullable()->after('deskripsi');
            $table->string('kondisi', 30)->default('baik')->after('jumlah');
            $table->string('foto_path')->nullable()->after('kondisi');
            $table->boolean('status_publish')->default(true)->after('foto_path');
        });
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'jumlah', 'kondisi', 'foto_path', 'status_publish']);
        });
    }
};
