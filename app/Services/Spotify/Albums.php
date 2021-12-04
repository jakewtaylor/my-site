<?php

namespace App\Services\Spotify;

use App\Contracts\Albums as AlbumsContract;
use App\Contracts\SpotifyAuth;
use App\Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Albums implements AlbumsContract
{
    /**
     * Flag to know if albums were retrieved or not
     *
     * @var boolean
     */
    protected $failed = false;

    protected $totalItems;

    protected $hasMore;

    protected $items;

    /**
     * Constructs the class.
     *
     * @param SpotifyAuth $auth
     */
    public function __construct(SpotifyAuth $auth, int $page = 1)
    {
        $this->client = new Client();

        try {
            $res = $this->getAlbums($page);
        } catch (RequestException $e) {
            $res = $e->getResponse();

            if ($res && $res->getStatusCode() === 401) {
                $auth->refreshTokens();

                try {
                    $res = $this->getAlbums($page);
                } catch (RequestException $e) {
                    $this->failed = true;
                    return;
                }
            } else {
                $this->failed = true;
                return;
            }
        }

        $contents = json_decode($res->getBody()->getContents());
        $items = collect($contents->items)->map(function ($item) {
            return $item->album;
        });

        $this->totalItems = $contents->total;
        $this->hasMore = !!$contents->next;
        $this->items = $items;
    }

    /**
     * Loads albums from the Spotify API.
     *
     * @return mixed The guzzle response
     */
    protected function getAlbums(int $page = 1, int $perPage = 50)
    {
        if ($cached = $this->items) {
            return $cached;
        }

        $token = Token::spotify('access_token');

        return $this->client->get('https://api.spotify.com/v1/me/albums', [
            'query' => [
                'limit' => $perPage,
                'offset' => ($page - 1) * $perPage,
            ],
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);
    }

    public function items()
    {
        // dd($this->items[0]);

        return $this->items->map(function ($item) {
            return [
                'name' => $item->name,
                'artist' => $item->artists[0]->name,
                'link' => $item->external_urls->spotify,
                'image' => $this->getAlbumArt($item),
            ];
        });
    }

    protected function getAlbumArt($album): ?string
    {
        $images = $album->images;

        if (count($images) < 1) return null;

        if (isset($images[1])) {
            return $images[1]->url;
        }

        return $images[0]->url;
    }

    public function totalCount()
    {
        return $this->totalItems;
    }

    public function hasMore()
    {
        return $this->hasMore;
    }
}
