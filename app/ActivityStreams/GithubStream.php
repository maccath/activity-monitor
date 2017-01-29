<?php

namespace App\ActivityStreams;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GithubStream extends PeriodicStream
{
    use DispatchesJobs;

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getItems(): Collection
    {
        $response = $this->client->get('/users/maccath/events');

        return collect(json_decode($response->getBody()->getContents()));
    }

    /**
     * @param mixed $item
     * @return \Carbon\Carbon
     */
    protected function getDateOf($item): Carbon
    {
        return new Carbon($item->created_at);
    }
}