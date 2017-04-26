<?php

namespace App\Providers;

use App\GitHub\ActivityStreams\GithubStream;
use App\Twitter\ActivityStreams\TwitterStream;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class StreamServiceProvider extends ServiceProvider
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
        $streamProviders = [
            TwitterStream::class,
            GithubStream::class,
        ];

        $this->app->tag($streamProviders, 'streams');

        $this->app->bind('TwitterStream', TwitterStream::class);
        $this->app->bind('GithubStream', GithubStream::class);

        $this->app->bind(TwitterStream::class, function () {
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
