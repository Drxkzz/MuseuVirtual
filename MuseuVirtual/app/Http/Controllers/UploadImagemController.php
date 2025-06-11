<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadImagemController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'Nenhuma imagem enviada.'], 400);
        }

        $file = $request->file('image');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Arquivo inválido.'], 400);
        }

        $path = $file->store('uploads', 'public');

        return response()->json([
            'url' => Storage::url($path) // ex: /storage/uploads/abc.jpg
        ]);
    }
}
