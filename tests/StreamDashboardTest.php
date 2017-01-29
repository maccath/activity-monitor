<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StreamDashboardTest extends TestCase
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

    public function testStreamFetchLoggedIn()
    {
        $this->actingAs(new \App\User())
          ->get('/streams/fetch/GithubStream')
          ->assertRedirect('/streams');
    }

    public function testStreamFetchNotLoggedIn()
    {
        $this->get('/streams/fetch/GithubStream')
          ->assertRedirect('/login');
    }
}
