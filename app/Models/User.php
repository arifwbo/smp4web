<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'role_id',
        'is_active',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function getRoleSlugAttribute(): ?string
    {
        return $this->role?->slug ?? $this->attributes['role'] ?? null;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::SUPER_ADMIN);
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = Arr::wrap($roles);

        return in_array($this->role_slug, $roles, true);
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->hasRole(Role::SUPER_ADMIN)) {
            return true;
        }

        if (! $this->relationLoaded('role')) {
            $this->load('role.permissions');
        } else {
            $this->role?->loadMissing('permissions');
        }

        $roleModel = $this->getRelationValue('role');
        if (! $roleModel instanceof Role) {
            return false;
        }

        return $roleModel->permissions?->contains('slug', $permission) ?? false;
    }

    public function assignRole(Role $role): void
    {
        $this->forceFill([
            'role_id' => $role->id,
            'role' => $role->slug,
        ])->save();
    }

    public function hasPanelAccess(): bool
    {
        return $this->role_slug !== null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
