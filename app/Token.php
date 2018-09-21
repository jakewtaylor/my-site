<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['name', 'value'];

    public static function spotify(string $name)
    {
        if ($name !== 'refresh_token' && $name !== 'access_token') {
            throw new InvalidArgumentException("Invalid name supplied to Token::spotify!");
        }

        return self::where('name', "spotify_$name")
                   ->firstOrFail()
                   ->value;
    }
}
