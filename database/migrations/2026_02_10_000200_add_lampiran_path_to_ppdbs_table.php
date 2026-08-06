<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ppdbs', function (Blueprint $table) {
            $table->string('lampiran_path')->nullable()->after('link_daftar');
        });
    }

    public function down(): void
    {
        Schema::table('ppdbs', function (Blueprint $table) {
            $table->dropColumn('lampiran_path');
        });
    }
};
