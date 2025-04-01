<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB
        ]);

        $path = $request->file('file')->store('uploads', 's3'); // Salva no MinIO

        $url = Storage::disk('s3')->url($path);

        return response()->json([
            'url' => $url,
        ]);
    }

    public function uploadFotos(Request $request)
    {
        $request->validate([
            'fotos.*' => 'required|image|max:10240',
        ]);

        $urls = [];
        foreach ($request->file('fotos') as $foto) {
            $caminho = $foto->store('fotos', 's3');
            $urlTemporaria = Storage::disk('s3')->temporaryUrl(
                $caminho,
                now()->addMinutes(5)
            );
            $urls[] = $urlTemporaria;
        }

        return response()->json(['urls' => $urls]);
    }
}
