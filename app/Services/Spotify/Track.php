<?php

namespace App\Services\Spotify;

use App\Token;
use App\Contracts\CurrentTrack;
use App\Contracts\SpotifyAuth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Track implements CurrentTrack {
    protected $failed = false;

    protected $client;

    public function __construct (SpotifyAuth $auth) {
        $this->client = new Client();


        try {
            $res = $this->getTrack();
        } catch (RequestException $e) {
            if ($e->getResponse()->getStatusCode() === 401) {
                $auth->refreshTokens();

                try {
                    $res = $this->getTrack();
                } catch (RequestException $e) {
                    $this->failed = true;
                    return;
                }
            } else {
                $this->failed = true;
                return;
            }
        }

        $this->track = json_decode($res->getBody()->getContents());
    }

    protected function getTrack()
    {
        $token = Token::spotify('access_token');

        return $this->client->get('https://api.spotify.com/v1/me/player/currently-playing', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);
    }

    public function hasTrack(): bool
    {
        return !$this->failed && $this->track && $this->track->is_playing;
    }

    public function getAlbumArt(): string
    {
        $images = $this->track->item->album->images;

        if (isset($images[1])) {
            return $images[1]->url;
        }

        return $images[0]->url;
    }

    public function getTrackName(): string
    {
        return $this->track->item->name;
    }

    public function getArtistName(): string
    {
        $artists = $this->track->item->artists;

        $artists = array_map(function ($artist) {
            return $artist->name;
        }, $artists);

        return implode(', ', $artists);
    }

    public function getAlbumName(): string
    {
        return $this->track->item->album->name;
    }
}
