<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ppdbs', function (Blueprint $table) {
            $table->json('lampiran_items')->nullable()->after('lampiran_path');
            $table->json('link_items')->nullable()->after('lampiran_items');
        });
    }

    public function down(): void
    {
        Schema::table('ppdbs', function (Blueprint $table) {
            $table->dropColumn(['lampiran_items', 'link_items']);
        });
    }
};
