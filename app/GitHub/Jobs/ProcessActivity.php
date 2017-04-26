<?php

namespace App\Github\Jobs;

use App\Github\Activity;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessActivity implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var \stdClass */
    private $activity;

    /**
     * @param \stdClass $activity activity data
     */
    public function __construct(\stdClass $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Process the received activity data.
     */
    public function handle()
    {
        $this->createActivity();
    }

    /**
     * Create eloquent model for activity
     */
    private function createActivity()
    {
        Activity::create([
          'id' => $this->activity->id,
          'json' => json_encode($this->activity),
          'type' => $this->activity->type ?? 'Unknown',
          'user_id' => $this->actor->id ?? null,
          'user_name' => $this->actor->login ?? null,
          'repo_id' => $this->repo->id ?? null,
          'repo_name' => $this->repo->name ?? null,
          'created_at' => Carbon::parse($this->activity->created_at ?? 'now'),
        ]);
    }
}
