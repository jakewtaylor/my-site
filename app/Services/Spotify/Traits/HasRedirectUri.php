<?php

namespace App\Services\Spotify\Traits;

trait HasRedirectUri {
    protected function getRedirectUri()
    {
        return route('setup.continue');
    }
}
