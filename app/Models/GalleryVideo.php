<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryVideo extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'youtube_url',
        'youtube_id',
    ];

    protected $appends = ['thumbnail_url', 'embed_url'];

    public function getThumbnailUrlAttribute(): string
    {
        return sprintf('https://img.youtube.com/vi/%s/hqdefault.jpg', $this->youtube_id);
    }

    public function getEmbedUrlAttribute(): string
    {
        return sprintf('https://www.youtube.com/embed/%s?rel=0', $this->youtube_id);
    }
}
