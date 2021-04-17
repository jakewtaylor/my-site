<?php

namespace App\Services\Spotify;

use App\Token;
use App\Palette;
use App\Contracts\CurrentTrack;
use App\Contracts\SpotifyAuth;
use ColorThief\ColorThief;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class Track implements CurrentTrack
{
    /**
     * Flag to know if the track was retrieved or not.
     *
     * @var boolean
     */
    protected $failed = false;

    /**
     * The Guzzle HTTP Client.
     *
     * @var Client
     */
    protected $client;

    /**
     * The current track.
     *
     * @var \stdObject
     */
    protected $track;

    /**
     * The color palette for the current album.
     *
     * @var \stdObject
     */
    protected $palette;

    /**
     * Constructs the class.
     *
     * @param SpotifyAuth $auth
     */
    public function __construct(SpotifyAuth $auth)
    {
        $this->client = new Client();

        try {
            $res = $this->getTrack();
        } catch (RequestException $e) {
            $res = $e->getResponse();
            if ($res && $res->getStatusCode() === 401) {
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

        $contents = $res->getBody()->getContents();

        if ($contents) {
            $this->track = json_decode($contents);

            if ($this->track->item) {
                $this->palette = $this->loadPalette();
            }
        }
    }

    /**
     * Determines if there is a track set.
     *
     * @return boolean
     */
    public function hasTrack(): bool
    {
        return !$this->failed && $this->track && $this->track->is_playing && $this->track->item;
    }

    /**
     * Determines if there is a palette set.
     *
     * @return boolean
     */
    public function hasPalette(): bool
    {
        return !$this->failed && $this->palette;
    }

    /**
     * Loads the current track from the Spotify API.
     *
     * @return mixed The guzzle response
     */
    protected function getTrack()
    {
        $token = Token::spotify('access_token');

        return $this->client->get('https://api.spotify.com/v1/me/player/currently-playing', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);
    }

    /**
     * Loads or creates the color palette for the album.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function loadPalette()
    {
        Log::debug('Track::loadPalette()', [
            'track' => $this->track,
        ]);

        $albumId = $this->track->item->album->id;
        $albumArtUrl = $this->getAlbumArt();

        $palette = Palette::forAlbum($albumId);

        if (!$palette) {
            $path = storage_path("albums/$albumId.jpg");
            try {
                $this->client->get($albumArtUrl, [
                    'sink' => $path,
                ]);

                $colorPalette = ColorThief::getPalette($path);

                $palette = Palette::create([
                    'album_id' => $albumId,
                    'album_art_url' => $albumArtUrl,
                    'palette' => $colorPalette,
                ]);

                unlink($path);
            } catch (\Exception $e) {
                dd($e);
            }
        }

        return $palette->palette;
    }

    /**
     * Gets the color palette.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPalette()
    {
        return $this->palette;
    }

    /**
     * Gets a URL to the album art.
     *
     * @return string
     */
    public function getAlbumArt(): ?string
    {
        $images = $this->track->item->album->images;

        if (count($images) < 1) {
            return null;
        }

        if (isset($images[1])) {
            return $images[1]->url;
        }

        return $images[0]->url;
    }

    /**
     * Gets the track name.
     *
     * @return string
     */
    public function getTrackName(): string
    {
        return $this->track->item->name;
    }

    /**
     * Gets the artist name.
     *
     * @return string
     */
    public function getArtistName(): string
    {
        $artists = $this->track->item->artists;

        $artists = array_map(function ($artist) {
            return $artist->name;
        }, $artists);

        return implode(', ', $artists);
    }

    /**
     * Gets the album name.
     *
     * @return string
     */
    public function getAlbumName(): string
    {
        return $this->track->item->album->name;
    }
}
