<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Lorenzo',
            'last_name' => 'Kniss',
            'email' => 'lorenzo@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}
