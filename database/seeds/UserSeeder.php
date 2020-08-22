<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $superAdmin = User::create([
           'first_name' => 'Jack',
            'last_name' => 'Doe',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('super123')
        ]);

        $admin = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123')
        ]);

        $user = User::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('user123')
        ]);

        $superAdmin->roles()->attach($superAdminRole);
        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}
