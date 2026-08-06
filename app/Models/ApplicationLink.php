<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationLink extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'link_url',
        'button_label',
        'image_path',
        'accent_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            $cleanPath = ltrim(preg_replace('/^(storage\/|media\/)+/', '', $this->image_path), '/');
            return url('media/' . $cleanPath);
        }

        return null;
    }
}
