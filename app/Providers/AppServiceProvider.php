<?php

namespace App\Providers;

use App\ActivityStreams\GithubStream;
use App\ActivityStreams\TwitterStream;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
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
            ->needs(ClientInterface::class)
            ->give(function () {
                return new Client([
                'base_uri' => 'https://api.github.com',
                'timeout' => 2.0,
                'headers' => [
                  'Authorization' => 'token ' . env('GITHUB_ACCESS_TOKEN', null)
                ]
            ]);
        });
    }
}
