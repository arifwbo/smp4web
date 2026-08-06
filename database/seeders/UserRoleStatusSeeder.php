<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleStatusSeeder extends Seeder
{
    public function run(): void
    {
        $viewerRole = Role::where('slug', Role::VIEWER)->first();
        $superRole = Role::where('slug', Role::SUPER_ADMIN)->first();

        if ($viewerRole) {
            User::query()
                ->where(function ($query) {
                    $query->whereNull('role_id')->orWhereNull('role');
                })
                ->each(function (User $user) use ($viewerRole) {
                    $user->forceFill([
                        'role_id' => $viewerRole->id,
                        'role' => $viewerRole->slug,
                        'is_active' => $user->is_active ?? true,
                    ])->save();
                });
        }

        $adminEmail = config('app.admin_email', 'admin@smpn4samarinda.sch.id');
        $admin = User::where('email', $adminEmail)->first();

        if ($admin && $superRole) {
            $admin->forceFill([
                'role_id' => $superRole->id,
                'role' => $superRole->slug,
                'is_active' => true,
            ])->save();
        }
    }
}
