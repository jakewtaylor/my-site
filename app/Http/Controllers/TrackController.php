<?php

namespace App\Http\Controllers;

use App\Contracts\CurrentTrack;

class TrackController extends Controller
{
    public function getTrack()
    {
        $track = app(CurrentTrack::class);

        if (!$track->hasTrack()) {
            return response()->json(null);
        }

        return response()->json([
            'album_art' => $track->hasAlbumArt() ? $track->getAlbumArt() : null,
            'album_name' => $track->getAlbumName(),
            'artist_name' => $track->getArtistName(),
            'track_name' => $track->getTrackName(),
        ]);
    }
}
