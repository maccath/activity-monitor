<?php

class TweetTest extends TestCase
{
    /**
     * Test that Tweet model exists
     */
    public function testTweetModelExists()
    {
        $tweet = new \App\Twitter\Tweet();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Model::class, $tweet);
    }
}
