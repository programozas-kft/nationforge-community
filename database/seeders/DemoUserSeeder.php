<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('DEMO_USER_EMAIL', 'demo@nationforge.hu');

        $editor = Role::firstOrCreate(['name' => 'editor']);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Demó felhasználó',
                'password' => bcrypt(\Illuminate\Support\Str::random(32)),
                'email_verified_at' => now(),
            ]
        );

        if (!$user->hasRole('editor')) {
            $user->assignRole($editor);
        }
    }
}
