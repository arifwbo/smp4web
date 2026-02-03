<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'hero_points' => 'array',
        'curriculum_highlights' => 'array',
        'subject_allocations' => 'array',
        'support_points' => 'array',
        'programs' => 'array',
        'extracurriculars' => 'array',
        'timelines' => 'array',
    ];
}
