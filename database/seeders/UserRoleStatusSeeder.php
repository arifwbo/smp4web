<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleStatusSeeder extends Seeder
{
    public function run(): void
    {
        User::query()
            ->whereNull('role')
            ->update(['role' => User::ROLE_USER]);

        User::query()
            ->whereNull('is_active')
            ->update(['is_active' => true]);

        $adminEmail = config('app.admin_email', 'admin@smpn4samarinda.sch.id');
        $admin = User::where('email', $adminEmail)->first();

        if ($admin) {
            $admin->update([
                'role' => User::ROLE_ADMIN,
                'is_active' => true,
            ]);
        }
    }
}
