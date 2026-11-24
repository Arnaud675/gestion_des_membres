<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->createUserFromEnvironment(
            config('initial_users.admin.email'),
            config('initial_users.admin.password'),
            config('initial_users.admin.name'),
            'admin'
        );

        $this->createUserFromEnvironment(
            config('initial_users.staff.email'),
            config('initial_users.staff.password'),
            config('initial_users.staff.name'),
            'manager'
        );
    }

    private function createUserFromEnvironment(?string $email, ?string $password, string $name, string $role): void
    {
        if (! $email || ! $password) {
            return;
        }

        \App\Models\User::firstOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => $password, 'role' => $role]
        );
    }

}
