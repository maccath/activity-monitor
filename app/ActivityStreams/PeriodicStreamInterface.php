<?php

namespace App\ActivityStreams;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;

interface PeriodicStreamInterface
{
    /**
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(ClientInterface $client);

    /**
     * Fetch new items
     */
    public function fetch();

    /**
     * @return Collection
     */
    public function getItems(): Collection;
}