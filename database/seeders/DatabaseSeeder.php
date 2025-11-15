<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'MDY',
            'email' => 'admin@ardanayatra.me',
            'password' => bcrypt('Ardanayatra123@#$'),
            'email_verified_at' => now(),
        ]);

        // Create categories
        Category::create([
            'name' => 'Music',
            'slug' => 'music',
        ]);

        Category::create([
            'name' => 'Coding',
            'slug' => 'coding',
        ]);
    }
}
