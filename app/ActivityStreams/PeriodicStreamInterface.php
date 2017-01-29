<?php

namespace App\ActivityStreams;

interface PeriodicStreamInterface
{
    /**
     * Fetch the latest activity
     */
    public function fetch();
}