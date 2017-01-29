<?php

namespace App\ActivityStreams;

trait HasDescription
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}