<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    protected $fillable = [
        'company',
        'url',
        'role',
        'started',
        'left',
    ];

    public static function current()
    {
        return self::whereNull('left')->latest()->first();
    }
}
