<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $member = Role::firstOrCreate(['name' => 'member']);

        $user = User::firstOrCreate(
            ['email' => 'admin@nationforge.hu'],
            [
                'name' => 'NationForge Admin',
                'password' => bcrypt('Admin1234!'),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole($superAdmin);
    }
}
