<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $superadmin = User::create([
            'name' => 'super admin',
            'email' => 'superadmin@email.com',
            'password' => Hash::make('samarinda'),
            'role_id' => 1,
            'status' => true,
        ]);

        $superadmin->assignRole('Super Admin');

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('samarinda'),
            'role_id' => 2,
            'status' => true,
        ]);

        $admin->assignRole('Admin');

        $hrd = User::create([
            'name' => 'arini',
            'email' => 'hrd@email.com',
            'password' => Hash::make('samarinda'),
            'role_id' => 3,
            'status' => true,
        ]);

        $hrd->assignRole('HRD');
    }
}
