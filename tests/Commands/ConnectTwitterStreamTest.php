<?php

class ConnectTwitterStreamTest extends TestCase
{
    /** @var \App\Twitter\ActivityStreams\TwitterStream */
    private $twitterStream;

    /** @var \App\Console\Commands\ConnectTwitterStream */
    private $connectTwitterStreamCommand;

    public function setUp()
    {
        parent::setUp();

        $this->twitterStream = Mockery::mock(\App\Twitter\ActivityStreams\TwitterStream::class)->makePartial();
        $this->connectTwitterStreamCommand = new \App\Console\Commands\ConnectTwitterStream($this->twitterStream);
    }

    /**
     * Test that ConnectTwitterStream implements Console\Command
     */
    public function testImplementsCommand()
    {
        $this->assertInstanceOf(\Illuminate\Console\Command::class, $this->connectTwitterStreamCommand);
    }

    /**
     * Test that the command connects the TwitterStream via the consume method
     */
    public function testHandleConnectsTwitterStream()
    {
        $this->twitterStream->shouldReceive('consume')->once();
        $this->twitterStream->shouldReceive('setTrack')->with(['@maccath'])->once();

        $this->connectTwitterStreamCommand->handle();
    }
}
