<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::latest()->paginate(20);
        return view('admin.songs.index', compact('songs'));
    }

    public function create()
    {
        return view('admin.songs.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'artist' => 'required|string|max:255',
                'serial_number' => 'nullable|string|max:50|unique:songs,serial_number',
                'audio_file' => 'required|string', // Path from AJAX upload
                'cover_image' => 'nullable|string', // Path from AJAX upload
                'markers' => 'nullable|array',
                'markers.*.label' => 'required_with:markers|string|max:50',
                'markers.*.time' => 'required_with:markers|numeric|min:0',
                'lyrics' => 'nullable|array',
                'lyrics.*.text' => 'required_with:lyrics|string',
                'lyrics.*.time' => 'required_with:lyrics|numeric|min:0',
            ]);

            // Verify files exist in R2
            if (!Storage::disk('r2')->exists($validated['audio_file'])) {
                throw new \Exception('File audio tidak ditemukan di R2. Silakan upload ulang.');
            }

            if (!empty($validated['cover_image']) && !Storage::disk('r2')->exists($validated['cover_image'])) {
                throw new \Exception('File cover tidak ditemukan di R2. Silakan upload ulang.');
            }

            Song::create($validated);

            return redirect()->route('admin.songs.index')
                            ->with('success', '✅ Lagu berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($e->errors())
                            ->with('error', '❌ Validasi gagal. Periksa form Anda.');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', '❌ Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function edit(Song $song)
    {
        return view('admin.songs.edit', compact('song'));
    }

    public function update(Request $request, Song $song)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'artist' => 'required|string|max:255',
                'serial_number' => 'nullable|string|max:50|unique:songs,serial_number,' . $song->id,
                'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:51200',
                'cover_image' => 'nullable|image|max:2048',
                'markers' => 'nullable|array',
                'markers.*.label' => 'required|string|max:50',
                'markers.*.time' => 'required|numeric|min:0',
                'lyrics' => 'nullable|array',
                'lyrics.*.text' => 'required|string',
                'lyrics.*.time' => 'required|numeric|min:0',
            ]);

            // Upload new audio file
            if ($request->hasFile('audio_file')) {
                $audioFile = $request->file('audio_file');
                
                // Validate file size
                if ($audioFile->getSize() > 50 * 1024 * 1024) {
                    throw new \Exception('File audio terlalu besar. Maksimal 50MB.');
                }
                
                // Upload to R2
                $audioPath = $audioFile->store('songs/audio', 'r2');
                
                if (!$audioPath) {
                    throw new \Exception('Gagal upload audio ke R2. Coba lagi.');
                }
                
                // Verify upload
                if (!Storage::disk('r2')->exists($audioPath)) {
                    throw new \Exception('Audio terupload tapi tidak ditemukan di R2.');
                }
                
                // Delete old file after successful upload
                if ($song->audio_file && Storage::disk('r2')->exists($song->audio_file)) {
                    Storage::disk('r2')->delete($song->audio_file);
                }
                
                $validated['audio_file'] = $audioPath;
            }

            // Upload new cover image
            if ($request->hasFile('cover_image')) {
                $coverFile = $request->file('cover_image');
                
                // Validate file size
                if ($coverFile->getSize() > 2 * 1024 * 1024) {
                    throw new \Exception('File cover terlalu besar. Maksimal 2MB.');
                }
                
                // Upload to R2
                $coverPath = $coverFile->store('songs/covers', 'r2');
                
                if (!$coverPath) {
                    throw new \Exception('Gagal upload cover ke R2. Coba lagi.');
                }
                
                // Verify upload
                if (!Storage::disk('r2')->exists($coverPath)) {
                    throw new \Exception('Cover terupload tapi tidak ditemukan di R2.');
                }
                
                // Delete old cover after successful upload
                if ($song->cover_image && Storage::disk('r2')->exists($song->cover_image)) {
                    Storage::disk('r2')->delete($song->cover_image);
                }
                
                $validated['cover_image'] = $coverPath;
            }

            $song->update($validated);

            return redirect()->route('admin.songs.index')
                            ->with('success', '✅ Lagu berhasil diupdate di Cloudflare R2!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($e->errors())
                            ->with('error', '❌ Validasi gagal. Periksa form Anda.');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', '❌ Gagal update ke R2: ' . $e->getMessage());
        }
    }

    public function destroy(Song $song)
    {
        try {
            // Delete files from R2
            if ($song->audio_file) {
                Storage::disk('r2')->delete($song->audio_file);
            }
            if ($song->cover_image) {
                Storage::disk('r2')->delete($song->cover_image);
            }

            $song->delete();

            return redirect()->route('admin.songs.index')
                            ->with('success', '✅ Lagu berhasil dihapus dari R2!');
        } catch (\Exception $e) {
            return redirect()->route('admin.songs.index')
                            ->with('error', '❌ Gagal hapus dari R2: ' . $e->getMessage());
        }
    }
}
