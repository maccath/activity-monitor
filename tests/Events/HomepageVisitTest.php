<?php

class HomepageVisitTest extends TestCase
{
    /**
     * Test that the event broadcasts on the private basic channel
     */
    public function testEventBroadcastsOnBasic()
    {
        $event = new \App\Events\HomepageVisit();

        $this->assertEquals('private-basic', $event->broadcastOn());
    }
}
