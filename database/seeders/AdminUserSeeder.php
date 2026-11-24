<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = config('initial_users.admin.email');
        $password = config('initial_users.admin.password');

        if (! $email || ! $password) {
            return;
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => config('initial_users.admin.name', 'Administrateur'),
                'password' => $password,
                'role' => 'admin',
            ]
        );
    }
}