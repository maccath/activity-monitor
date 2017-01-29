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

    /** @var Collection */
    protected $items;

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

        $items = $this->fetchItems()
            ->filter(function ($item) {
                if (!$this->lastFetch()) return true;

                return $this->getDateOf($item)->gt($this->lastFetch());
            });

        $this->updateLastFetch();

        $this->items = $items;
        $this->process();
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection {
        return $this->items;
    }

    protected function process() {
        $this->items->each(function ($item) {
            $this->processItem($item);
        });
    }

    abstract protected function processItem($item);

    /**
     * @return Collection
     */
    abstract protected function fetchItems(): Collection;


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