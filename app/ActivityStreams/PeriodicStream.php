<?php

namespace App\ActivityStreams;

use App\StreamStatus;
use Carbon\Carbon;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;

abstract class PeriodicStream implements PeriodicStreamInterface
{
    /** @var \GuzzleHttp\ClientInterface */
    protected $client;

    /** @var Carbon */
    protected $fetchedAt = null;

    /**
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Fetch new activity
     */
    public function fetch()
    {
        $this->fetchedAt = new Carbon();

        $items = $this->getItems()
            ->filter(function ($item) {
                if (!$this->lastFetch()) return true;

                return $this->getDateOf($item)->gt($this->lastFetch());
            });

        $this->updateLastFetch();

        return $items;
    }

    /**
     * @return Collection
     */
    abstract protected function getItems(): Collection;

    /**
     * @param mixed $item
     * @return Carbon
     */
    abstract protected function getDateOf($item): Carbon;

    /**
     * @return Carbon|null
     */
    protected function lastFetch()
    {
        return StreamStatus::whereName(self::class)->value('last_fetch');
    }

    protected function updateLastFetch()
    {
        StreamStatus::updateOrCreate(
          ['name' => self::class],
          ['last_fetch' => $this->fetchedAt]
        );
    }
}