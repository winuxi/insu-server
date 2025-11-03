<?php

namespace Database\Seeders;

use App\Models\MultiTenant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([DefaultRoleSeeder::class, DefaultPermissionSeeder::class]);

        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'tenant_id' => null,
            ]
        );

        $superAdmin->assignRole('super-admin');

        $adminTenant = MultiTenant::firstOrCreate(['tenant_username' => 'admin']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'tenant_id' => $adminTenant->id,
            ]
        );

        $admin->assignRole('admin');

        Role::where('name', '!=', User::SUPER_ADMIN)->update(['tenant_id' => $adminTenant->id]);

        $this->call([DefaultDataSeeder::class]);
    }
}
