<?php

namespace Database\Seeders;

use App\Models\ChordPreset;
use Illuminate\Database\Seeder;

class ChordPresetSeeder extends Seeder
{
    public function run(): void
    {
        $chords = [
            // ============================================
            // SIMPLE CHORDS (Natural notes only)
            // ============================================

            // --- C FAMILY (SIMPLE) ---
            ['name'=>'C', 'family'=>'C', 'type'=>'major', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>3], ['string'=>2,'fret'=>2], ['string'=>4,'fret'=>1]],
                'open_strings'=>[3,5], 'muted_strings'=>[0]
            ],
            ['name'=>'Cm', 'family'=>'C', 'type'=>'minor', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>3], ['string'=>1,'fret'=>4], ['string'=>2,'fret'=>5],
                    ['string'=>3,'fret'=>5], ['string'=>4,'fret'=>4], ['string'=>5,'fret'=>3]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'C7', 'family'=>'C', 'type'=>'7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>3], ['string'=>2,'fret'=>2], ['string'=>3,'fret'=>3], ['string'=>4,'fret'=>1]],
                'open_strings'=>[5], 'muted_strings'=>[0]
            ],
            ['name'=>'Cmaj7', 'family'=>'C', 'type'=>'maj7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>3], ['string'=>2,'fret'=>2]],
                'open_strings'=>[3,4,5], 'muted_strings'=>[0]
            ],

            // --- D FAMILY (SIMPLE) ---
            ['name'=>'D', 'family'=>'D', 'type'=>'major', 'difficulty'=>'simple',
                'fingers'=>[['string'=>3,'fret'=>2], ['string'=>2,'fret'=>3], ['string'=>1,'fret'=>2]],
                'open_strings'=>[4], 'muted_strings'=>[0,1]
            ],
            ['name'=>'Dm', 'family'=>'D', 'type'=>'minor', 'difficulty'=>'simple',
                'fingers'=>[['string'=>3,'fret'=>2], ['string'=>2,'fret'=>3], ['string'=>1,'fret'=>1]],
                'open_strings'=>[4], 'muted_strings'=>[0,1]
            ],
            ['name'=>'D7', 'family'=>'D', 'type'=>'7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>3,'fret'=>2], ['string'=>2,'fret'=>1], ['string'=>1,'fret'=>2]],
                'open_strings'=>[4], 'muted_strings'=>[0,1]
            ],
            ['name'=>'Dmaj7', 'family'=>'D', 'type'=>'maj7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>3,'fret'=>2], ['string'=>2,'fret'=>2], ['string'=>1,'fret'=>2]],
                'open_strings'=>[4], 'muted_strings'=>[0,1]
            ],

            // --- E FAMILY (SIMPLE) ---
            ['name'=>'E', 'family'=>'E', 'type'=>'major', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>2], ['string'=>2,'fret'=>2], ['string'=>3,'fret'=>1]],
                'open_strings'=>[0,4,5], 'muted_strings'=>[]
            ],
            ['name'=>'Em', 'family'=>'E', 'type'=>'minor', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>2], ['string'=>2,'fret'=>2]],
                'open_strings'=>[0,3,4,5], 'muted_strings'=>[]
            ],
            ['name'=>'E7', 'family'=>'E', 'type'=>'7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>2], ['string'=>3,'fret'=>1]],
                'open_strings'=>[0,2,4,5], 'muted_strings'=>[]
            ],
            ['name'=>'Emaj7', 'family'=>'E', 'type'=>'maj7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>2], ['string'=>2,'fret'=>1], ['string'=>3,'fret'=>1]],
                'open_strings'=>[0,4,5], 'muted_strings'=>[]
            ],

            // --- F FAMILY (SIMPLE) ---
            ['name'=>'F', 'family'=>'F', 'type'=>'major', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>1], ['string'=>1,'fret'=>3], ['string'=>2,'fret'=>3],
                    ['string'=>3,'fret'=>2], ['string'=>4,'fret'=>1], ['string'=>5,'fret'=>1]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'Fm', 'family'=>'F', 'type'=>'minor', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>1], ['string'=>1,'fret'=>3], ['string'=>2,'fret'=>3],
                    ['string'=>3,'fret'=>1], ['string'=>4,'fret'=>1], ['string'=>5,'fret'=>1]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'F7', 'family'=>'F', 'type'=>'7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>1], ['string'=>1,'fret'=>3], ['string'=>2,'fret'=>1],
                    ['string'=>3,'fret'=>2], ['string'=>4,'fret'=>1], ['string'=>5,'fret'=>1]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'Fmaj7', 'family'=>'F', 'type'=>'maj7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>1], ['string'=>1,'fret'=>3], ['string'=>2,'fret'=>2],
                    ['string'=>3,'fret'=>2], ['string'=>4,'fret'=>1]],
                'open_strings'=>[5], 'muted_strings'=>[]
            ],

            // --- G FAMILY (SIMPLE) ---
            ['name'=>'G', 'family'=>'G', 'type'=>'major', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>3], ['string'=>1,'fret'=>2], ['string'=>5,'fret'=>3]],
                'open_strings'=>[2,3,4], 'muted_strings'=>[]
            ],
            ['name'=>'Gm', 'family'=>'G', 'type'=>'minor', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>3], ['string'=>1,'fret'=>5], ['string'=>2,'fret'=>5],
                    ['string'=>3,'fret'=>3], ['string'=>4,'fret'=>3], ['string'=>5,'fret'=>3]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'G7', 'family'=>'G', 'type'=>'7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>3], ['string'=>1,'fret'=>2], ['string'=>5,'fret'=>1]],
                'open_strings'=>[2,3,4], 'muted_strings'=>[]
            ],
            ['name'=>'Gmaj7', 'family'=>'G', 'type'=>'maj7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>0,'fret'=>3], ['string'=>1,'fret'=>2], ['string'=>5,'fret'=>2]],
                'open_strings'=>[2,3,4], 'muted_strings'=>[]
            ],

            // --- A FAMILY (SIMPLE) ---
            ['name'=>'A', 'family'=>'A', 'type'=>'major', 'difficulty'=>'simple',
                'fingers'=>[['string'=>2,'fret'=>2], ['string'=>3,'fret'=>2], ['string'=>4,'fret'=>2]],
                'open_strings'=>[1,5], 'muted_strings'=>[0]
            ],
            ['name'=>'Am', 'family'=>'A', 'type'=>'minor', 'difficulty'=>'simple',
                'fingers'=>[['string'=>2,'fret'=>2], ['string'=>3,'fret'=>2], ['string'=>4,'fret'=>1]],
                'open_strings'=>[1,5], 'muted_strings'=>[0]
            ],
            ['name'=>'A7', 'family'=>'A', 'type'=>'7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>2,'fret'=>2], ['string'=>4,'fret'=>2]],
                'open_strings'=>[1,3,5], 'muted_strings'=>[0]
            ],
            ['name'=>'Amaj7', 'family'=>'A', 'type'=>'maj7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>2,'fret'=>2], ['string'=>3,'fret'=>1], ['string'=>4,'fret'=>2]],
                'open_strings'=>[1,5], 'muted_strings'=>[0]
            ],

            // --- B FAMILY (SIMPLE) ---
            ['name'=>'B', 'family'=>'B', 'type'=>'major', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>2], ['string'=>2,'fret'=>4], ['string'=>3,'fret'=>4],
                    ['string'=>4,'fret'=>4], ['string'=>5,'fret'=>2]],
                'open_strings'=>[], 'muted_strings'=>[0]
            ],
            ['name'=>'Bm', 'family'=>'B', 'type'=>'minor', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>2], ['string'=>2,'fret'=>4], ['string'=>3,'fret'=>4],
                    ['string'=>4,'fret'=>3], ['string'=>5,'fret'=>2]],
                'open_strings'=>[], 'muted_strings'=>[0]
            ],
            ['name'=>'B7', 'family'=>'B', 'type'=>'7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>2], ['string'=>2,'fret'=>1], ['string'=>3,'fret'=>2], ['string'=>5,'fret'=>2]],
                'open_strings'=>[4], 'muted_strings'=>[0]
            ],
            ['name'=>'Bmaj7', 'family'=>'B', 'type'=>'maj7', 'difficulty'=>'simple',
                'fingers'=>[['string'=>1,'fret'=>2], ['string'=>2,'fret'=>4], ['string'=>3,'fret'=>3],
                    ['string'=>4,'fret'=>4], ['string'=>5,'fret'=>2]],
                'open_strings'=>[], 'muted_strings'=>[0]
            ],

            // ============================================
            // ADVANCED CHORDS (Sharp/Flat notes)
            // ============================================

            // --- Ab/G# FAMILY (ADVANCED) ---
            ['name'=>'Ab', 'family'=>'Ab', 'type'=>'major', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>4], ['string'=>1,'fret'=>6], ['string'=>2,'fret'=>6],
                    ['string'=>3,'fret'=>5], ['string'=>4,'fret'=>4], ['string'=>5,'fret'=>4]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'Abm', 'family'=>'Ab', 'type'=>'minor', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>4], ['string'=>1,'fret'=>6], ['string'=>2,'fret'=>6],
                    ['string'=>3,'fret'=>4], ['string'=>4,'fret'=>4], ['string'=>5,'fret'=>4]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],

            // --- Bb FAMILY (ADVANCED) ---
            ['name'=>'Bb', 'family'=>'Bb', 'type'=>'major', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>1], ['string'=>1,'fret'=>3], ['string'=>2,'fret'=>3],
                    ['string'=>3,'fret'=>3], ['string'=>4,'fret'=>1], ['string'=>5,'fret'=>1]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'Bbm', 'family'=>'Bb', 'type'=>'minor', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>1], ['string'=>1,'fret'=>3], ['string'=>2,'fret'=>3],
                    ['string'=>3,'fret'=>1], ['string'=>4,'fret'=>1], ['string'=>5,'fret'=>1]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],

            // --- C#/Db FAMILY (ADVANCED) ---
            ['name'=>'C#', 'family'=>'C#', 'type'=>'major', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>4], ['string'=>1,'fret'=>6], ['string'=>2,'fret'=>6],
                    ['string'=>3,'fret'=>6], ['string'=>4,'fret'=>4], ['string'=>5,'fret'=>4]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'C#m', 'family'=>'C#', 'type'=>'minor', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>4], ['string'=>1,'fret'=>5], ['string'=>2,'fret'=>6],
                    ['string'=>3,'fret'=>6], ['string'=>4,'fret'=>5], ['string'=>5,'fret'=>4]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],

            // --- D#/Eb FAMILY (ADVANCED) ---
            ['name'=>'Eb', 'family'=>'Eb', 'type'=>'major', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>6], ['string'=>1,'fret'=>8], ['string'=>2,'fret'=>8],
                    ['string'=>3,'fret'=>8], ['string'=>4,'fret'=>6], ['string'=>5,'fret'=>6]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'Ebm', 'family'=>'Eb', 'type'=>'minor', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>6], ['string'=>1,'fret'=>8], ['string'=>2,'fret'=>8],
                    ['string'=>3,'fret'=>6], ['string'=>4,'fret'=>6], ['string'=>5,'fret'=>6]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],

            // --- F#/Gb FAMILY (ADVANCED) ---
            ['name'=>'F#', 'family'=>'F#', 'type'=>'major', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>2], ['string'=>1,'fret'=>4], ['string'=>2,'fret'=>4],
                    ['string'=>3,'fret'=>3], ['string'=>4,'fret'=>2], ['string'=>5,'fret'=>2]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'F#m', 'family'=>'F#', 'type'=>'minor', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>2], ['string'=>1,'fret'=>4], ['string'=>2,'fret'=>4],
                    ['string'=>3,'fret'=>2], ['string'=>4,'fret'=>2], ['string'=>5,'fret'=>2]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],

            // --- G#/Ab FAMILY (ADVANCED) ---
            ['name'=>'G#', 'family'=>'G#', 'type'=>'major', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>4], ['string'=>1,'fret'=>6], ['string'=>2,'fret'=>6],
                    ['string'=>3,'fret'=>5], ['string'=>4,'fret'=>4], ['string'=>5,'fret'=>4]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
            ['name'=>'G#m', 'family'=>'G#', 'type'=>'minor', 'difficulty'=>'advanced',
                'fingers'=>[['string'=>0,'fret'=>4], ['string'=>1,'fret'=>6], ['string'=>2,'fret'=>6],
                    ['string'=>3,'fret'=>4], ['string'=>4,'fret'=>4], ['string'=>5,'fret'=>4]],
                'open_strings'=>[], 'muted_strings'=>[]
            ],
        ];

        foreach ($chords as $chord) {
            ChordPreset::create($chord);
        }
    }
}
