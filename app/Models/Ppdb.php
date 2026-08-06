<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ppdb extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'judul',
        'konten',
        'status',
        'link_daftar',
        'lampiran_path',
        'lampiran_items',
        'link_items',
    ];

    protected $casts = [
        'lampiran_items' => 'array',
        'link_items' => 'array',
    ];

    public function getLampiranUrlAttribute(): ?string
    {
        return $this->lampiran_path ? asset('storage/' . $this->lampiran_path) : null;
    }

    public function getLampiranCollectionAttribute(): array
    {
        $items = collect($this->lampiran_items ?? []);

        if ($items->isEmpty() && $this->lampiran_path) {
            $items = collect([['label' => 'Lampiran', 'path' => $this->lampiran_path]]);
        }

        return $items
            ->map(function ($item, $index) {
                $path = $item['path'] ?? null;

                return [
                    'label' => $item['label'] ?? 'Lampiran ' . ($index + 1),
                    'path' => $path,
                    'url' => $path ? asset('storage/' . $path) : null,
                ];
            })
            ->filter(fn ($item) => ! empty($item['url']))
            ->values()
            ->all();
    }

    public function getLinkCollectionAttribute(): array
    {
        $items = collect($this->link_items ?? []);

        if ($items->isEmpty() && $this->link_daftar) {
            $items = collect([['label' => 'Link Pendaftaran', 'url' => $this->link_daftar]]);
        }

        return $items
            ->map(function ($item, $index) {
                $url = $item['url'] ?? null;

                return [
                    'label' => $item['label'] ?? 'Tautan ' . ($index + 1),
                    'url' => $url,
                ];
            })
            ->filter(fn ($item) => ! empty($item['url']))
            ->values()
            ->all();
    }
}
