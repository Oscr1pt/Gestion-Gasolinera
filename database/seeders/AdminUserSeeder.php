<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gasolinera.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
                'estado' => true,
                'role' => 'admin',
            ]
        );
    }
}
