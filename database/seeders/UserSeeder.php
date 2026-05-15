<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Buat Super Admin
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'phone' => '081234567890',
            'address' => 'Jl. Pendidikan No. 1, Jakarta',
        ]);
        $superAdmin->assignRole('super-admin');

        // 2. Buat 3 Akun Guru
        for ($i = 1; $i <= 3; $i++) {
            $guru = User::create([
                'name' => $faker->name,
                'email' => "guru{$i}@sekolah.com",
                'password' => Hash::make('password123'),
                'is_active' => true,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
            $guru->assignRole('guru');
        }

        // 3. Buat 10 Akun Murid
        for ($i = 1; $i <= 10; $i++) {
            $murid = User::create([
                'name' => $faker->name,
                'email' => "murid{$i}@sekolah.com",
                'password' => Hash::make('password123'),
                'is_active' => true,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
            $murid->assignRole('murid');
        }
    }
}
