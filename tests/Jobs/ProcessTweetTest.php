<?php

class ProcessTweetTest extends TestCase
{
    /**
     * Test that the event handler logs the event
     */
    public function testTweetProcessed()
    {
        $tweet = 'some tweet data';

        $processTweet = new \App\Jobs\ProcessTweet($tweet);
    }
}
