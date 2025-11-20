<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    /**
     * Upload audio file to R2
     */
    public function uploadAudio(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'audio' => 'required|file|mimes:mp3,wav,ogg,m4a|max:51200',
            ]);
            
            $file = $request->file('audio');
            
            // Check file size
            if ($file->getSize() > 50 * 1024 * 1024) {
                throw new \Exception('File terlalu besar. Maksimal 50MB.');
            }
            
            // Check if file is valid
            if (!$file->isValid()) {
                throw new \Exception('File tidak valid atau corrupt. Coba file lain.');
            }
            
            Log::info('Uploading audio to R2', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);
            
            // Test R2 connection first
            try {
                Storage::disk('r2')->put('test-connection.txt', 'test');
                Storage::disk('r2')->delete('test-connection.txt');
            } catch (\Exception $e) {
                Log::error('R2 Connection Test Failed', [
                    'error' => $e->getMessage(),
                ]);
                throw new \Exception('Koneksi ke R2 gagal. Error: ' . $e->getMessage());
            }
            
            // Upload to R2
            try {
                $path = $file->store('songs/audio', 'r2');
            } catch (\Exception $e) {
                Log::error('R2 Store Failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                throw new \Exception('Upload gagal: ' . $e->getMessage());
            }
            
            if (!$path) {
                throw new \Exception('Gagal upload ke R2. Path kosong.');
            }
            
            // Verify file exists in R2
            if (!Storage::disk('r2')->exists($path)) {
                throw new \Exception('File terupload tapi tidak ditemukan di R2. Coba lagi.');
            }
            
            // Get file size in R2
            $r2Size = Storage::disk('r2')->size($path);
            
            Log::info('Audio uploaded successfully to R2', [
                'path' => $path,
                'r2_size' => $r2Size,
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Audio berhasil diupload ke R2!',
                'path' => $path,
                'file_size' => $file->getSize(),
                'r2_size' => $r2Size,
                'original_name' => $file->getClientOriginalName(),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $message = 'Validasi gagal: ';
            
            if (isset($errors['audio'])) {
                $message .= implode(', ', $errors['audio']);
            } else {
                $message .= 'File tidak valid.';
            }
            
            Log::warning('Audio upload validation failed', [
                'errors' => $errors,
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            Log::error('R2 Audio Upload Error', [
                'message' => $e->getMessage(),
                'file' => $request->file('audio') ? $request->file('audio')->getClientOriginalName() : 'no file',
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'help' => 'Periksa: 1) Koneksi internet, 2) Kredensial R2 di .env, 3) File tidak corrupt',
            ], 500);
        }
    }

    /**
     * Upload cover image to R2
     */
    public function uploadCover(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'cover' => 'required|image|max:2048',
            ]);
            
            $file = $request->file('cover');
            
            // Check file size
            if ($file->getSize() > 2 * 1024 * 1024) {
                throw new \Exception('File terlalu besar. Maksimal 2MB.');
            }
            
            // Check if file is valid
            if (!$file->isValid()) {
                throw new \Exception('File tidak valid atau corrupt. Coba file lain.');
            }
            
            Log::info('Uploading cover to R2', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);
            
            // Test R2 connection first
            try {
                Storage::disk('r2')->put('test-connection.txt', 'test');
                Storage::disk('r2')->delete('test-connection.txt');
            } catch (\Exception $e) {
                Log::error('R2 Connection Test Failed', [
                    'error' => $e->getMessage(),
                ]);
                throw new \Exception('Koneksi ke R2 gagal. Error: ' . $e->getMessage());
            }
            
            // Upload to R2
            try {
                $path = $file->store('songs/covers', 'r2');
            } catch (\Exception $e) {
                Log::error('R2 Store Failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                throw new \Exception('Upload gagal: ' . $e->getMessage());
            }
            
            if (!$path) {
                throw new \Exception('Gagal upload ke R2. Path kosong.');
            }
            
            // Verify file exists in R2
            if (!Storage::disk('r2')->exists($path)) {
                throw new \Exception('File terupload tapi tidak ditemukan di R2. Coba lagi.');
            }
            
            Log::info('Cover uploaded successfully to R2', [
                'path' => $path,
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Cover berhasil diupload ke R2!',
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $message = 'Validasi gagal: ';
            
            if (isset($errors['cover'])) {
                $message .= implode(', ', $errors['cover']);
            } else {
                $message .= 'File tidak valid.';
            }
            
            Log::warning('Cover upload validation failed', [
                'errors' => $errors,
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            Log::error('R2 Cover Upload Error', [
                'message' => $e->getMessage(),
                'file' => $request->file('cover') ? $request->file('cover')->getClientOriginalName() : 'no file',
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'help' => 'Periksa: 1) Koneksi internet, 2) Kredensial R2 di .env, 3) File tidak corrupt',
            ], 500);
        }
    }
}
