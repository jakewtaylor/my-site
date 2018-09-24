<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Palette extends Model
{
    protected $fillable = ['album_id', 'album_art_url', 'palette'];

    protected $casts = [
        'palette' => 'collection',
    ];

    public static function forAlbum(string $albumId): ?self
    {
        return Palette::where('album_id', $albumId)->first();
    }
}
