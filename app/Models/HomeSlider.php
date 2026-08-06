<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            $cleanPath = ltrim(preg_replace('/^(storage\/|media\/)+/', '', $this->image_path), '/');
            return url('media/' . $cleanPath);
        }

        return asset('img/placeholder.jpg');
    }
}
