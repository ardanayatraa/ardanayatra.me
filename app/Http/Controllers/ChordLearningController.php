<?php

namespace App\Http\Controllers;

use App\Models\ChordPreset;
use Illuminate\Http\Request;

class ChordLearningController extends Controller
{
    public function index()
    {
        $families = ChordPreset::select('family')->distinct()->orderBy('family')->pluck('family');
        $chords = ChordPreset::where('difficulty', 'simple')->orderBy('family')->orderBy('name')->get();
        
        return view('chord-learning.index', compact('families', 'chords'));
    }
}
