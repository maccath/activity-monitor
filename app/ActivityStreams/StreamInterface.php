<?php

namespace App\ActivityStreams;

interface StreamInterface
{
    const PERIODIC = 'Periodic';
    const CONTINUAL = 'Continual';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getType(): string;
}