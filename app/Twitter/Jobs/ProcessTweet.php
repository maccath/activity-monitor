<?php

namespace App\Twitter\Jobs;

use App\Twitter\Tweet;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessTweet implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    private $tweet;

    /** @var array */
    private $decodedTweet;

    /**
     * ProcessTweet constructor.
     *
     * @param string $tweet the raw tweet data
     */
    public function __construct($tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Process the received tweet data.
     *
     * Note: we use id_str rather than id because the integers are too large
     */
    public function handle()
    {
        $this->decodeTweet();
        $this->checkData();
        $this->createTweet();
    }

    /**
     * JSON decode the tweet
     *
     * @throws \Exception if not valid JSON
     */
    private function decodeTweet()
    {
        $this->decodedTweet = json_decode($this->tweet, true);

        if (! $this->decodedTweet) {
            throw new \Exception('Tweet is invalid JSON');
        }
    }

    /**
     * Ensure that required data is present
     *
     * @throws \Exception if data missing
     */
    private function checkData()
    {
        if (! isset($this->decodedTweet['id']) && ! isset($this->decodedTweet['id_str'])) {
            throw new \Exception('Tweet does not have an ID.');
        }

        if (! isset($this->decodedTweet['user'])) {
            throw new \Exception('Tweet does not have user data.');
        }
    }

    /**
     * Create eloquent model for tweet
     */
    private function createTweet()
    {
        Tweet::create([
          'id' => $this->decodedTweet['id_str'] ?? $this->decodedTweet['id'],
          'json' => $this->tweet,
          'text' => $this->decodedTweet['text'] ?? '',
          'user_id' => $this->decodedTweet['user']['id_str'] ?? $this->decodedTweet['user']['id'] ?? null,
          'user_screen_name' => $this->decodedTweet['user']['screen_name']?? null,
          'created_at' => Carbon::parse($this->decodedTweet['created_at'] ?? 'now'),
        ]);
    }
}
