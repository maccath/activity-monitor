<?php

class TwitterStreamTest extends TestCase
{
    /** @var \App\Twitter\ActivityStreams\TwitterStream */
    private $twitterStream;

    public function setUp()
    {
        parent::setUp();

        $this->twitterStream = $this
          ->getMockBuilder(\App\Twitter\ActivityStreams\TwitterStream::class)
          ->disableOriginalConstructor()
          ->setMethods(null)
          ->getMock();
    }

    /**
     * Test that TwitterStream implements OauthPhirehose
     */
    public function testImplementsPhirehose()
    {
        $this->assertInstanceOf(OauthPhirehose::class, $this->twitterStream);
    }

    /**
     * Test that when the Stream receives a tweet, a ProcessTweet job is queued
     */
    public function testReceivedTweetDispatchesJob()
    {
        $this->expectsJobs([\App\Twitter\Jobs\ProcessTweet::class]);

        $this->twitterStream->enqueueStatus('some test');
    }
}
