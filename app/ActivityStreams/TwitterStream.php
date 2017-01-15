<?php

namespace App\ActivityStreams;

use App\Jobs\ProcessTweet;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TwitterStream extends \OauthPhirehose
{
    use DispatchesJobs;

    /**
     * Enqueue each newly received Tweet from the stream and dispatch a job for
     * later processing
     *
     * @param string $status the raw tweet
     */
    public function enqueueStatus($status)
    {
        $this->dispatch(new ProcessTweet($status));
    }
}