<?php

class GithubStreamTest extends TestCase
{
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
}
