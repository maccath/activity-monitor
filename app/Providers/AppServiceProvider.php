<?php

namespace App\Providers;

use App\ActivityStreams\GithubStream;
use App\ActivityStreams\TwitterStream;
use GuzzleHttp\Client;
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

        $this->app->when(GithubStream::class)
            ->needs(Client::class)
            ->give(function () {
                return new Client([
            ]);
        });
    }
}
