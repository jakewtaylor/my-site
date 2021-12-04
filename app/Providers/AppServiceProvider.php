<?php

namespace App\Providers;

use App\Workplace;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use App\Contracts\SpotifyAuth;
use App\Services\Spotify\Auth;

use App\Contracts\CurrentTrack;
use App\Services\Spotify\Track;

use App\Contracts\Albums as AlbumsContract;
use App\Services\Spotify\Albums;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('workplace', function () {
            $workplace = Workplace::current();

            return "<a href=\"{$workplace->url}\" target=\"_blank\" rel=\"noopener\">{$workplace->company}</a>";
        });

        $this->app->bind(SpotifyAuth::class, Auth::class);
        $this->app->bind(CurrentTrack::class, Track::class);
        $this->app->bind(AlbumsContract::class, Albums::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
