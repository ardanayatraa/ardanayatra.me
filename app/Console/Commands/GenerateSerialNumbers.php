<?php

namespace App\Console\Commands;

use App\Models\Song;
use Illuminate\Console\Command;

class GenerateSerialNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'songs:generate-serial-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate serial numbers for existing songs without serial numbers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating serial numbers for existing songs...');
        
        $songs = Song::whereNull('serial_number')->orderBy('id')->get();
        
        if ($songs->isEmpty()) {
            $this->info('All songs already have serial numbers!');
            return 0;
        }
        
        $lastSong = Song::whereNotNull('serial_number')->orderBy('id', 'desc')->first();
        $nextNumber = $lastSong ? (intval(substr($lastSong->serial_number, -3)) + 1) : 1;
        
        $bar = $this->output->createProgressBar($songs->count());
        $bar->start();
        
        foreach ($songs as $song) {
            $song->serial_number = 'IMAY-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $song->save();
            $nextNumber++;
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Successfully generated ' . $songs->count() . ' serial numbers!');
        
        return 0;
    }
}
