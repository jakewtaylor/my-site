<?php

namespace App\Console\Commands;

use App\Contracts\SpotifyAuth;
use App\Services\Spotify\Traits\HasRedirectUri;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Command;

class SetupSpotify extends Command
{
    use HasRedirectUri;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up spotify authentication.';

    /**
     * @var SpotifyAuth
     */
    protected $auth;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SpotifyAuth $auth)
    {
        parent::__construct();

        $this->auth = $auth;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->getAuthUrl();

        $this->info('Visit this URL to continue setup: ');
        $this->info("\t$url");

        $code = $this->ask('Enter the code you were given:');

        try {
            $this->auth->getInitialTokens($code);

            $this->info("All done!");
        } catch (RequestException $e) {
            $this->error("Something went wrong! Dumping error...");

            dd($e);
        }
    }

    protected function getAuthUrl(): string
    {
        return $this->buildUrl(
            'https://accounts.spotify.com/authorize',
            $this->getAuthQueryParams(),
        );
    }

    protected function getAuthQueryParams()
    {
        return [
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri' => $this->getRedirectUri(),
            'scope' => 'user-read-currently-playing user-library-read',
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
