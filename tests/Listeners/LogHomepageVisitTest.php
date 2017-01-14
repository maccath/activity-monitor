<?php

class LogHomepageVisitTest extends TestCase
{
    /**
     * Test that the event handler logs the event
     */
    public function testEventLogged()
    {
        $listener = new \App\Listeners\LogHomepageVisit();

        Log::shouldReceive('info')->once();

        $listener->handle(new \App\Events\HomepageVisit());
  }
}
