<?php

namespace App\ActivityStreams;

trait HasName
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}