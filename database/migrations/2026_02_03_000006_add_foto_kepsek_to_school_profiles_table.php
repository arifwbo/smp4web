<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('school_profiles', 'foto_kepsek')) {
            Schema::table('school_profiles', function (Blueprint $table) {
                $table->string('foto_kepsek')->nullable()->after('sambutan_kepsek');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('school_profiles', 'foto_kepsek')) {
            Schema::table('school_profiles', function (Blueprint $table) {
                $table->dropColumn('foto_kepsek');
            });
        }
    }
};
