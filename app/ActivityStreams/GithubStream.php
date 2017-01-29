<?php

namespace App\ActivityStreams;

use App\StreamStatus;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GithubStream implements PeriodicStreamInterface
{
    use DispatchesJobs;

    /** @var \GuzzleHttp\Client */
    private $client;

    /** @var Carbon */
    private $fetchedAt = null;

    /**
     * @param \GuzzleHttp\Client $githubClient
     */
    public function __construct(Client $githubClient)
    {
        $this->client = $githubClient;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fetch()
    {
        $response = $this->client->get('/users/maccath/events');
        $this->fetchedAt = new Carbon();

        $items = collect(json_decode($response->getBody()->getContents()))
            ->filter(function ($item) {
                if (!$this->lastFetch()) return true;

                $createdAt = new Carbon($item->created_at);

                return $createdAt->gt($this->lastFetch());
            });

        $this->updateLastFetch();

        return $items;
    }

    /**
     * @return Carbon|null
     */
    private function lastFetch()
    {
        return StreamStatus::whereName(self::class)->value('last_fetch');
    }

    private function updateLastFetch()
    {
        StreamStatus::updateOrCreate(
          ['name' => self::class],
          ['last_fetch' => $this->fetchedAt]
        );
    }
}