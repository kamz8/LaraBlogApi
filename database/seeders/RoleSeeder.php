<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'User',
                'description' => 'Regular user role',
                'slug' => 'user',
            ],
            [
                'name' => 'Moderator',
                'description' => 'Moderator role',
                'slug' => 'moderator',
            ],
            [
                'name' => 'Admin',
                'description' => 'Admin role',
                'slug' => 'admin',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
