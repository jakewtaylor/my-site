<?php

namespace App\Services\Spotify;

use App\Token;
use App\Contracts\SpotifyAuth;
use App\Services\Spotify\Traits\HasRedirectUri;
use GuzzleHttp\Client;

class Auth implements SpotifyAuth
{
    use HasRedirectUri;

    /**
     * The HTTP client we will be using.
     *
     * @var Client
     */
    protected $client;

    /**
     * Creates the class.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://accounts.spotify.com',
        ]);
    }

    /**
     * Gets the initial tokens from the auth flow code spotify gives us.
     *
     * @param string $code
     * @return void
     */
    public function getInitialTokens(string $code)
    {
        $res = $this->client->post('/api/token', [
            'form_params' => [
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $this->getRedirectUri(),
            ],
            'headers' => [
                'Authorization' => $this->getAuthHeader(),
            ],
        ]);

        $this->handleResponse($res, true);
    }

    /**
     * Gets new tokens based on the existing refresh token.
     *
     * @return void
     */
    public function refreshTokens()
    {
        $refreshToken = Token::spotify('refresh_token');

        $res = $this->client->post('/api/token', [
            'form_params' => [
                'refresh_token' => $refreshToken,
                'grant_type' => 'refresh_token',
            ],
            'headers' => [
                'Authorization' => $this->getAuthHeader(),
            ],
        ]);

        $this->handleResponse($res);
    }

    /**
     * Handles an auth response
     *
     * @param mixed $response
     * @return void
     */
    protected function handleResponse($response, $includeRefresh = false)
    {
        $body = json_decode($response->getBody()->getContents());

        if ($includeRefresh) {
            $this->saveTokens($body->access_token, $body->refresh_token);
        } else {
            $this->saveTokens($body->access_token);
        }
    }

    /**
     * Gets the Authorization header.
     *
     * @return string
     */
    protected function getAuthHeader(): string
    {
        $id = env('SPOTIFY_CLIENT_ID');
        $secret = env('SPOTIFY_CLIENT_SECRET');

        $token = base64_encode("$id:$secret");

        return "Basic $token";
    }

    /**
     * Saves the specified tokens to the database.
     *
     * @param string $access
     * @param string $refresh
     * @return void
     */
    protected function saveTokens($access, $refresh = null)
    {
        $accessToken = Token::firstOrNew(['name' => 'spotify_access_token']);
        $accessToken->value = $access;
        $accessToken->save();

        if ($refresh) {
            $refreshToken = Token::firstOrNew(['name' => 'spotify_refresh_token']);
            $refreshToken->value = $refresh;
            $refreshToken->save();
        }
    }
}
