<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    public const SUPER_ADMIN = 'super-admin';
    public const ADMIN_CONTENT = 'admin-konten';
    public const ADMIN_AKADEMIK = 'admin-akademik';
    public const ADMIN_SARPRAS = 'admin-sarpras';
    public const ADMIN_PPDB = 'admin-ppdb';
    public const VIEWER = 'viewer';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_system',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions->contains(fn (Permission $perm) => $perm->slug === $permission);
    }
}
