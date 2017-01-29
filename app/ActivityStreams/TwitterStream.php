<?php

namespace App\ActivityStreams;

use App\Jobs\ProcessTweet;
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
        return self::CONTINUAL;
    }
}