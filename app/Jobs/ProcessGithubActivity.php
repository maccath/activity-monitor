<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessGithubActivity implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var \stdClass */
    private $activity;

    /**
     * @param \stdClass $activity activity data
     */
    public function __construct(\stdClass $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Process the received activity data.
     */
    public function handle()
    {
        $this->createActivity();
    }

    /**
     * Create eloquent model for activity
     */
    private function createActivity()
    {
        // Todo: implementation
    }
}
