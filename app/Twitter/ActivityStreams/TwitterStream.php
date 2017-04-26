<?php

namespace App\Twitter\ActivityStreams;

use App\ActivityStreams\ContinualStreamInterface;
use App\ActivityStreams\HasDescription;
use App\ActivityStreams\HasName;
use App\ActivityStreams\StreamInterface;
use App\Twitter\Jobs\ProcessTweet;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TwitterStream extends \OauthPhirehose implements ContinualStreamInterface
{
    use DispatchesJobs;
    use HasName;
    use HasDescription;

    /** @var string  */
    protected $name = 'Twitter Stream';

    /** @var string  */
    protected $description = 'Fetch Twitter activity.';

    /**
     * Enqueue each newly received Tweet from the stream and dispatch a job for
     * later processing
     *
     * @param string $status the raw tweet
     */
    public function enqueueStatus($status)
    {
        $this->dispatch(new ProcessTweet($status));
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return StreamInterface::CONTINUAL;
    }
}