<?php

namespace App\Jobs;

use App\Actions\ActionInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PerformAction implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    private $action;
    /** @var array */
    private $arguments;

    /**
     * @param string $action
     * @param array $arguments
     * @throws \Exception if given action not an action
     */
    public function __construct(string $action, array $arguments)
    {
        $this->action = $action;
        $this->arguments = $arguments;

        if (! make($this->action, $arguments) instanceof ActionInterface) {
            throw new \Exception(sprintf('%s not an action.', $this->action));
        }
    }

    /**
     * @throws \Exception if action failed
     */
    public function handle()
    {
        try {
            $action = make($this->action, $this->arguments);
            $action->perform();
        } catch (\Exception $e) {
            throw new \Exception(sprintf(
                'Action could not be performed successfully: %s',
                $e->getMessage()
            ));
        }
    }
}
