<?php

namespace App\ActivityStreams;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;

interface PeriodicStreamInterface extends StreamInterface
{
    /**
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(ClientInterface $client);

    /**
     * Get items consumed
     *
     * @return Collection
     */
    public function getItems(): Collection;
}