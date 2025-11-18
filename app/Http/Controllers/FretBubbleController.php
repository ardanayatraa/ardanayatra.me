<?php

namespace App\Http\Controllers;

use App\Models\ChordPreset;
use Illuminate\Http\Request;

class FretBubbleController extends Controller
{
    public function index()
    {
        $families = ChordPreset::select('family')->distinct()->orderBy('family')->pluck('family');
        return view('fretbubble.index', compact('families'));
    }

    public function getPresets(Request $request)
    {
        $query = ChordPreset::query();
        
        if ($request->filled('family')) {
            $query->where('family', $request->family);
        }
        
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }
        
        return response()->json($query->get());
    }

    public function getPreset($id)
    {
        $preset = ChordPreset::findOrFail($id);
        return response()->json($preset);
    }
}
