<?php

namespace App\Contracts;

interface SpotifyAuth
{
    public function getInitialTokens(string $code);

    public function refreshTokens();
}
