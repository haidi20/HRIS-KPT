<?php

namespace Database\Seeders;

use App\Models\Panlak;
use App\Models\Panggar;
use App\Models\Media;
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
            'password' => Hash::make('Samarinda123'),
            'role_id' => 1,
            'status' => true,
        ]);

        $superadmin->assignRole('Super Admin');

        $superadmin = User::create([
            'name' => 'admin',
            'email' => 'admin@addmin.com',
            'password' => Hash::make('Samarinda123'),
            'role_id' => 2,
            'status' => true,
        ]);

        $superadmin->assignRole('Admin');
    }
}
