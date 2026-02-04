<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FormerPrincipal extends Model
{
    protected $guarded = [];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if (! $this->photo_path) {
            $placeholder = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="240" height="240" viewBox="0 0 240 240">
    <rect width="240" height="240" rx="60" fill="#f3f4f6" />
    <circle cx="120" cy="90" r="60" fill="#e0e7ff" />
    <rect x="50" y="150" width="140" height="80" rx="40" fill="#c7d2fe" />
    <text x="120" y="215" font-size="26" text-anchor="middle" fill="#94a3b8">{{NAME}}</text>
</svg>
SVG;
            $nameLabel = Str::upper(Str::limit($this->name ?? 'Kepsek', 12, ''));
            $svg = str_replace('{{NAME}}', htmlspecialchars($nameLabel, ENT_QUOTES), $placeholder);

            return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
        }

        return asset('storage/' . $this->photo_path);
    }
}
