<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();

        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@erp.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
            'preferred_language' => 'en',
        ]);

        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@erp.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
            'preferred_language' => 'en',
        ]);

        $demoUser = User::create([
            'name' => 'Demo User',
            'email' => 'demo@erp.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
            'preferred_language' => 'en',
        ]);

        if ($superAdminRole) {
            $superAdmin->roles()->attach($superAdminRole);
        }

        if ($adminRole) {
            $admin->roles()->attach($adminRole);
            $demoUser->roles()->attach($adminRole);
        }
    }
}
