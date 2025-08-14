<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'cpf' => '00000000000',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }
}
