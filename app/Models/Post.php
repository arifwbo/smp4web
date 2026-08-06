<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Post $post) {
            $post->slug = static::generateUniqueSlug($post->judul, $post->id);
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            $cleanPath = ltrim(preg_replace('/^(storage\/|media\/)+/', '', $this->gambar), '/');
            return url('media/' . $cleanPath);
        }

        return asset('img/placeholder.jpg');
    }

    public function getLampiranUrlAttribute(): ?string
    {
        return $this->lampiran_path ? asset('storage/' . $this->lampiran_path) : null;
    }
}
