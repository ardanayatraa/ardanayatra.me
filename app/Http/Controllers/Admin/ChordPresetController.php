<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChordPreset;
use Illuminate\Http\Request;

class ChordPresetController extends Controller
{
    public function index(Request $request)
    {
        $query = ChordPreset::query();
        
        if ($request->filled('family')) {
            $query->where('family', $request->family);
        }
        
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }
        
        $chords = $query->orderBy('family')->orderBy('name')->paginate(20);
        $families = ChordPreset::select('family')->distinct()->orderBy('family')->pluck('family');
        
        return view('admin.chord-presets.index', compact('chords', 'families'));
    }

    public function create()
    {
        return view('admin.chord-presets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'difficulty' => 'required|in:simple,advanced',
            'fingers' => 'required|json',
            'open_strings' => 'nullable|json',
            'muted_strings' => 'nullable|json',
            'starting_fret' => 'required|integer|min:0',
            'num_frets' => 'required|integer|min:3|max:12',
            'num_strings' => 'required|integer|min:4|max:8',
        ]);

        // Decode JSON strings to arrays before saving
        $validated['fingers'] = json_decode($validated['fingers'], true);
        $validated['open_strings'] = json_decode($validated['open_strings'] ?? '[]', true);
        $validated['muted_strings'] = json_decode($validated['muted_strings'] ?? '[]', true);

        ChordPreset::create($validated);

        return redirect()->route('admin.chord-presets.index')
            ->with('success', 'Chord preset created successfully.');
    }

    public function edit(ChordPreset $chordPreset)
    {
        return view('admin.chord-presets.edit', compact('chordPreset'));
    }

    public function update(Request $request, ChordPreset $chordPreset)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'difficulty' => 'required|in:simple,advanced',
            'fingers' => 'required|json',
            'open_strings' => 'nullable|json',
            'muted_strings' => 'nullable|json',
            'starting_fret' => 'required|integer|min:0',
            'num_frets' => 'required|integer|min:3|max:12',
            'num_strings' => 'required|integer|min:4|max:8',
        ]);

        // Decode JSON strings to arrays before saving
        $validated['fingers'] = json_decode($validated['fingers'], true);
        $validated['open_strings'] = json_decode($validated['open_strings'] ?? '[]', true);
        $validated['muted_strings'] = json_decode($validated['muted_strings'] ?? '[]', true);

        $chordPreset->update($validated);

        return redirect()->route('admin.chord-presets.index')
            ->with('success', 'Chord preset updated successfully.');
    }

    public function destroy(ChordPreset $chordPreset)
    {
        $chordPreset->delete();

        return redirect()->route('admin.chord-presets.index')
            ->with('success', 'Chord preset deleted successfully.');
    }
}
