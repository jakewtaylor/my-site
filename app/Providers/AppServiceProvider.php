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

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('age', function () {
            $age = Carbon::createFromFormat('Y-m-d', env('DOB'))->age;

            return $age;
        });

        Blade::directive('workplace', function () {
            $workplace = Workplace::current();

            return "<a href=\"{$workplace->url}\" target=\"_blank\" rel=\"noopener\">{$workplace->company}</a>";
        });

        $this->app->bind(SpotifyAuth::class, Auth::class);
        $this->app->bind(CurrentTrack::class, Track::class);
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
