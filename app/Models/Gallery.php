<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
    ];

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->gambar);
    }
}
