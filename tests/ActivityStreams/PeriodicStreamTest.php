<?php

class PeriodicStreamTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    /** @var \App\ActivityStreams\PeriodicStream */
    private $stream;

    /** @var string fake API response body */
    private $fakeResponseBody;

    public function setUp()
    {
        parent::setUp();

        $client = $this->getMockBuilder(\GuzzleHttp\Client::class)
          ->disableOriginalConstructor()
          ->setMethods(['get'])
          ->getMock();

        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
          ->disableOriginalConstructor()
          ->setMethods(['getBody'])
          ->getMock();

        $this->fakeResponseBody = $this->getMockBuilder(\GuzzleHttp\Psr7\Stream::class)
          ->disableOriginalConstructor()
          ->setMethods(['getContents'])
          ->getMock();

        $client->method('get')->willReturn($response);
        $response->method('getBody')->willReturn($this->fakeResponseBody);

        $this->stream = $this->getMockForTrait(\App\ActivityStreams\PeriodicStream::class, [$client]);
    }

    public function testGetFetchUrl()
    {
        $this->assertNotEmpty($this->stream->getConsumeUrl());
        $this->assertContains('/streams/consume', $this->stream->getConsumeUrl());
        $this->assertNotContains('App\ActivityStreams', $this->stream->getConsumeUrl());
    }

    public function testGetType()
    {
        $this->assertEquals('Periodic', $this->stream->getType());
    }
}
