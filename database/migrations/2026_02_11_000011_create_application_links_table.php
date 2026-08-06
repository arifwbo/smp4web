<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('application_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link_url');
            $table->string('button_label')->default('Buka Aplikasi');
            $table->string('image_path')->nullable();
            $table->string('accent_color', 20)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_links');
    }
};
