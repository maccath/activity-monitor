<?php

namespace App\GitHub\ActivityStreams;

use App\ActivityStreams\PeriodicStream;
use App\ActivityStreams\PeriodicStreamInterface;
use App\GitHub\Jobs\ProcessActivity;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GithubStream implements PeriodicStreamInterface
{
    use DispatchesJobs;
    use PeriodicStream;

    /** @var string  */
    protected $name = 'Github Stream';

    /** @var string  */
    protected $description = 'Fetch github activity.';

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function fetchItems(): Collection
    {
        $response = $this->client->get('/users/maccath/events');

        return collect(json_decode($response->getBody()->getContents()));
    }

    /**
     * Enqueue each newly received activity from the stream and dispatch a job for
     * later processing
     *
     * @param mixed $item
     */
    protected function processItem($item)
    {
        $this->dispatch(new ProcessActivity($item));
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