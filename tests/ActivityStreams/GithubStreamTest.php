<?php

class GithubStreamTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    /** @var \App\ActivityStreams\GithubStream */
    private $githubStream;

    public function setUp()
    {
        parent::setUp();

        $this->githubStream = resolve(\App\ActivityStreams\GithubStream::class);
    }

    /**
     * Test that GithubStream implements PeriodicStreamInterface
     */
    public function testImplementsPeriodicStream()
    {
        $this->assertInstanceOf(\App\ActivityStreams\PeriodicStreamInterface::class, $this->githubStream);
    }

    public function testFetchGetsLatestItems()
    {
        // First fetch, all items
        $this->assertNotEmpty($this->githubStream->fetch());

        // Second fetch, shouldn't be any items left to fetch!
        $this->assertEmpty($this->githubStream->fetch());
    }
}
