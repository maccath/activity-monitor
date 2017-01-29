<?php

namespace App\ActivityStreams;

interface ContinualStreamInterface extends StreamInterface
{
    /**
     * Commence consumption of stream
     *
     * @return mixed
     */
    public function consume();
}