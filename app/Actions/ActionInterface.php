<?php

namespace App\Actions;

interface ActionInterface
{
    /**
     * @return mixed
     */
    public function perform();
}