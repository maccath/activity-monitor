<?php

namespace App\Console\Commands;

use App\ActivityStreams\TwitterStream;
use Illuminate\Console\Command;

class ConnectTwitterStream extends Command
{
    /** @var string  */
    protected $signature = 'stream:twitter';

    /** @var string  */
    protected $description = 'Connect to the Twitter activity stream';

    /** @var \App\ActivityStreams\TwitterStream */
    protected $twitterStream;

    /**
     * ConnectTwitterStream constructor.
     *
     * @param \App\ActivityStreams\TwitterStream $twitterStream
     */
    public function __construct(TwitterStream $twitterStream)
    {
        $this->twitterStream = $twitterStream;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->twitterStream->consumerKey = env('TWITTER_CONSUMER_KEY', '');
        $this->twitterStream->consumerSecret = env('TWITTER_CONSUMER_SECRET', '');

        $this->twitterStream->setTrack(['@maccath']);
        $this->twitterStream->consume();
    }
}
