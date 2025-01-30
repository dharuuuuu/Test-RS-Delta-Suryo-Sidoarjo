<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding user
        $dokter = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('dokter'),
            ]);
        $apoteker = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'apoteker@gmail.com',
                'password' => Hash::make('apoteker'),
            ]);
        $this->call(UserSeeder::class);
        $this->call(PermissionsSeeder::class);
    }
}
