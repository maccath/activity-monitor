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

    public function testImplementsPeriodicStream()
    {
        $this->assertInstanceOf(\App\ActivityStreams\PeriodicStreamInterface::class, $this->githubStream);
    }

    public function testFetchGetsLatestItems()
    {
        // First fetch, all items
        $this->githubStream->fetch();
        $this->assertNotEmpty($this->githubStream->getItems());

        // Second fetch, shouldn't be any items left to fetch!
        $this->githubStream->fetch();
        $this->assertEmpty($this->githubStream->getItems());
    }

    public function testNewActivityDispatchesJob()
    {
        $this->expectsJobs([\App\Jobs\ProcessGithubActivity::class]);

        $this->githubStream->fetch();
    }
}
