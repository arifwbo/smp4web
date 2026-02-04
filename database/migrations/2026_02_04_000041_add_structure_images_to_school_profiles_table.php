<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('struktur_guru_image')->nullable()->after('struktur_guru');
            $table->string('struktur_tu_image')->nullable()->after('struktur_tu');
        });
    }

    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn(['struktur_guru_image', 'struktur_tu_image']);
        });
    }
};
