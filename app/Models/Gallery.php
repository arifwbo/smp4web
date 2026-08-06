<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->gambar) {
            $cleanPath = ltrim(preg_replace('/^(storage\/|media\/)+/', '', $this->gambar), '/');
            return url('media/' . $cleanPath);
        }

        return asset('img/placeholder.jpg');
    }
}
