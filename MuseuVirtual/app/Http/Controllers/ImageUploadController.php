<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            $url = Storage::url($path);
            return response()->json(['location' => $url]);
        }
        return response()->json(['error' => 'Nenhum arquivo enviado'], 400);
    }

    public function picker()
    {
        $files = Storage::disk('public')->files('uploads');
        // Gere URLs públicas
        $images = array_map(function ($file) {
            return asset('storage/' . $file);
        }, $files);

        // Retorne uma página Inertia
        return inertia('ImagePicker', [
            'images' => $images
        ]);
    }
}
