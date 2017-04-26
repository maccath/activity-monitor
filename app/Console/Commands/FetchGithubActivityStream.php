<?php

namespace App\Console\Commands;

use App\GitHub\ActivityStreams\GithubStream;
use Illuminate\Console\Command;

class FetchGithubActivityStream extends Command
{
    /** @var string  */
    protected $signature = 'stream:github';

    /** @var string  */
    protected $description = 'Fetch the Github activity stream';

    /** @var \App\GitHub\ActivityStreams\GithubStream */
    protected $githubActivityStream;

    /**
     * ConnectTwitterStream constructor.
     *
     * @param \App\GitHub\ActivityStreams\GithubStream $githubStream
     */
    public function __construct(GithubStream $githubStream)
    {
        $this->githubActivityStream = $githubStream;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->githubActivityStream->consume();
    }
}
