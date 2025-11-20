<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder tidak digunakan karena audio file harus diupload manual ke R2
        // Gunakan admin panel untuk menambah lagu: /admin/songs/create
        
        $this->command->info('⚠️  Song seeder dilewati. Upload lagu via admin panel.');
        $this->command->info('📍 URL: /admin/songs/create');
    }
}
