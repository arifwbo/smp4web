<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->text('hero_description')->nullable();
            $table->json('hero_points')->nullable();
            $table->string('cta_teacher_label')->nullable();
            $table->string('cta_teacher_link')->nullable();
            $table->string('cta_ppdb_label')->nullable();
            $table->string('cta_ppdb_link')->nullable();
            $table->json('curriculum_highlights')->nullable();
            $table->json('subject_allocations')->nullable();
            $table->json('support_points')->nullable();
            $table->json('programs')->nullable();
            $table->json('extracurriculars')->nullable();
            $table->json('timelines')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_settings');
    }
};
