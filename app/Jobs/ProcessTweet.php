<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessTweet implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    private $tweet;

    /**
     * ProcessTweet constructor.
     *
     * @param string $tweet the raw tweet data
     */
    public function __construct($tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Process the tweet.
     */
    public function handle()
    {

    }
}
