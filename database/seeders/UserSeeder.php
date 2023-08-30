<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        //Create admin user first
        $admin = User::firstOrCreate([
            'name' => 'admin',
            'role_id' => $adminRole->id,
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), // Start example password
        ]);

        $roles = Role::where('slug', '!=', 'admin')->get();
//random user with different attached role
        User::factory(10)->create()->each(function ($user) use ($roles) {
            $randomRole = $roles->random();
            $user->role()->associate($randomRole);
        });

    }
}
