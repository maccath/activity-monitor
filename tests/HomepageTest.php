<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomepageTest extends TestCase
{
    /**
     * Test that the homepage can be viewed
     */
    public function testHomepageView()
    {
        $this->visit('/')
             ->see('Laravel');
    }

    /**
     * Test that the homepage visit event is triggered when visiting homepage
     */
    public function testHomepageVisitLogged()
    {
        $this->expectsEvents(\App\Events\HomepageVisit::class);

        $this->visit('/');
    }
}
