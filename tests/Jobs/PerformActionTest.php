<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PerformActionTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * Test that an unregistered action can't be performed
     *
     * @expectedException \Exception
     */
    public function testCantPerformFakeAction()
    {
        $mockMaker = Mockery::mock(\Greabock\Maker\Maker::class)->shouldIgnoreMissing();

        $this->app->instance(\Greabock\Maker\Maker::class, $mockMaker);

        new \App\Jobs\PerformAction('FakeAction', []);
    }

    /**
     * Test that the action is performed
     */
    public function testPerformAction()
    {
        $mockAction = Mockery::mock(\App\Actions\ActionInterface::class);
        $mockAction->shouldReceive('perform')->times(1)->andReturn(true);

        $mockMaker = Mockery::mock(\Greabock\Maker\Maker::class)->shouldIgnoreMissing();
        $mockMaker->shouldReceive('make')->with('SomeAction', [])->andReturn($mockAction);

        $this->app->instance(\Greabock\Maker\Maker::class, $mockMaker);

        $performAction = new \App\Jobs\PerformAction('SomeAction', []);

        $performAction->handle();
    }

    /**
     * Test that the job errors if action fails
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Action could not be performed successfully: Action failed!!!
     */
    public function testPerformActionFailed()
    {
        $mockAction = Mockery::mock(\App\Actions\ActionInterface::class);
        $mockAction->shouldReceive('perform')->times(1)->andThrow(new \Exception('Action failed!!!'));

        $mockMaker = Mockery::mock(\Greabock\Maker\Maker::class)->shouldIgnoreMissing();
        $mockMaker->shouldReceive('make')->with('SomeAction', [])->andReturn($mockAction);

        $this->app->instance(\Greabock\Maker\Maker::class, $mockMaker);

        $performAction = new \App\Jobs\PerformAction('SomeAction', []);

        $performAction->handle();
    }
}
