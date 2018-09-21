<?php

namespace App\Http\Controllers\Spotify;

use App\Http\Controllers\Controller;
use App\Contracts\SpotifyAuth;
use App\Services\Spotify\Traits\HasRedirectUri;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Http\Request;

class SetupController extends Controller {
    use HasRedirectUri;

    /**
     * Redirects to the spotify auth page.
     *
     * @return void
     */
    public function setup(Request $request)
    {
        $passcode = $request->get('passcode');

        if ($passcode !== env('PASSCODE')) {
            return redirect('/');
        }

        $params = $this->getAuthQueryParams();
        $url = 'https://accounts.spotify.com/authorize';
        $url = $this->buildUrl($url, $params);

        return redirect($url);
    }

    /**
     * Handles the spotify auth response.
     *
     * @param Request $request
     * @return void
     */
    public function continue(Request $request, SpotifyAuth $auth)
    {
        $code = $request->input('code');

        try {
            $auth->getInitialTokens($code);

            return view('setup.done');
        } catch (RequestException $e) {
            return view('setup.retry');
        }
    }

    protected function getAuthQueryParams()
    {
        return [
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri' => $this->getRedirectUri(),
            'scope' => 'user-read-currently-playing',
        ];
    }

    protected function buildUrl($url, $query = [])
    {
        $parts = [];

        foreach ($query as $key => $val) {
            $parts[] = "$key=$val";
        }

        $queryString = count($parts) > 0 ? '?' . implode('&', $parts) : '';

        return $url . $queryString;
    }
}
