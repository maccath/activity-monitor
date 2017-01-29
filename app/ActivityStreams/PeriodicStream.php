<?php

namespace App\ActivityStreams;

use App\StreamStatus;
use Carbon\Carbon;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;

trait PeriodicStream
{
    use HasName;
    use HasDescription;

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
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @return Carbon|null
     */
    public function lastFetch()
    {
        return StreamStatus::whereName(static::class)->value('last_fetch');
    }

    /**
     * Process collected items
     */
    protected function process()
    {
        $this->items->each(function ($item) {
            $this->processItem($item);
        });
    }

    /**
     * Process individual item
     *
     * @param $item
     * @return mixed
     */
    abstract protected function processItem($item);

    /**
     * Fetch collection of items from API
     *
     * @return Collection
     */
    abstract protected function fetchItems(): Collection;

    /**
     * Get date created of item
     *
     * @param mixed $item
     * @return Carbon
     */
    abstract protected function getDateOf($item): Carbon;

    protected function updateLastFetch()
    {
        StreamStatus::updateOrCreate(
          ['name' => static::class],
          ['last_fetch' => $this->fetchedAt]
        );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::PERIODIC;
    }
}