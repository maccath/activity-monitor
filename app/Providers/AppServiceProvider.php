<?php

namespace App\Providers;

use App\ActivityStreams\TwitterStream;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\ActivityStreams\TwitterStream', function ($app) {
            return new TwitterStream(
              env('TWITTER_ACCESS_TOKEN', null),
              env('TWITTER_ACCESS_TOKEN_SECRET', null),
              \Phirehose::METHOD_FILTER
            );
        });
    }
}
