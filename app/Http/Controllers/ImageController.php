<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use ColorThief\ColorThief;
use Illuminate\Http\Request;

class ImageController extends Controller {
    public function getColorPalette(Request $request)
    {
        $request->validate([
            'image_url' => 'required|url',
        ]);

        $imageUrl = $request->get('image_url');

        $palette = ColorThief::getPalette($imageUrl);

        return response()->json([
            'palette' => $palette,
        ]);
    }
}
