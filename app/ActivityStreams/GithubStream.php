<?php

namespace App\ActivityStreams;

use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GithubStream implements PeriodicStreamInterface
{
    use DispatchesJobs;

    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * @param \GuzzleHttp\Client $githubClient
     */
    public function __construct(Client $githubClient)
    {
        $this->client = $githubClient;
    }

    /**
     *
     */
    public function check() {}
}