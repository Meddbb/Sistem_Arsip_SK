<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $tiDivision = Division::where('kode', 'TI')->first();

        // Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sk.com',
            'password' => Hash::make('Admin1234'),
            'role' => 'admin',
            'division_id' => null,
        ]);

        // Anggota Divisi TI
        User::create([
            'name' => 'Anggota Divisi TI',
            'email' => 'anggota1@sk.com',
            'password' => Hash::make('Member1234'),
            'role' => 'anggota_divisi',
            'division_id' => $tiDivision->id,
        ]);

        // Tamu
        User::create([
            'name' => 'Tamu',
            'email' => 'tamu@sk.com',
            'password' => Hash::make('Tamu1234'),
            'role' => 'tamu',
            'division_id' => null,
        ]);
    }
}