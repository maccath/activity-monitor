<?php

namespace App\Listeners;

use App\Events\HomepageVisit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogHomepageVisit
{
    /**
     * LogHomepageVisit constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  HomepageVisit  $event
     * @return void
     */
    public function handle(HomepageVisit $event)
    {
        $this->logHomepageVisit();
    }

    /**
     *
     */
    private function logHomepageVisit()
    {
        Log::info('Homepage visited.');
    }
}
