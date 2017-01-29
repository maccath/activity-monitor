<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testStreamDashboardLoggedIn()
    {
        $this->actingAs(new \App\User())
          ->get('/streams')
          ->assertViewHas('streams');
    }

    public function testStreamDashboardNotLoggedIn()
    {
        $this->get('/streams')
          ->assertRedirect('/login');
    }

    public function testStreamFetchNotLoggedIn()
    {
        $this->get('/streams/fetch/GithubStream')
          ->assertRedirect('/login');
    }
}
