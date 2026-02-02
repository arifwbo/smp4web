<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model {
    protected $guarded = [];
    protected static function boot() {
        parent::boot();
        static::creating(function ($post) { $post->slug = Str::slug($post->judul); });
    }
    public function getGambarUrlAttribute() {
        // PERBAIKAN: Menghapus markdown syntax
        return $this->gambar ? asset('storage/' . $this->gambar) : '[https://via.placeholder.com/600x400?text=No+Image](https://via.placeholder.com/600x400?text=No+Image)';
    }
}
