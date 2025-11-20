<?php

namespace App\Console\Commands;

use App\Models\Song;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSongSlugs extends Command
{
    protected $signature = 'songs:generate-slugs';
    protected $description = 'Generate slugs for existing songs without slugs';

    public function handle()
    {
        $this->info('Generating slugs for existing songs...');
        
        $songs = Song::whereNull('slug')->get();
        
        if ($songs->isEmpty()) {
            $this->info('All songs already have slugs!');
            return 0;
        }
        
        $bar = $this->output->createProgressBar($songs->count());
        $bar->start();
        
        foreach ($songs as $song) {
            $song->slug = Str::slug($song->title);
            $song->save();
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Successfully generated ' . $songs->count() . ' slugs!');
        
        return 0;
    }
}
