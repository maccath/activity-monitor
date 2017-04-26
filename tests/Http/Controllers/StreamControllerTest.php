<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StreamControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testStreamFetch()
    {
        $streamMock = Mockery::mock(\App\Github\ActivityStreams\GithubStream::class)->makePartial();
        $sessionMock = Mockery::mock(\Illuminate\Session\Store::class)->makePartial();
        $requestMock = Mockery::mock(\Illuminate\Http\Request::class)->makePartial();

        $streamMock->shouldReceive('getName')->andReturn('Test Stream');
        $streamMock->shouldReceive('getItems')->andReturn(collect(['one', 'two']));
        $requestMock->shouldReceive('session')->andReturn($sessionMock);

        // Assert that we fetch items from the stream
        $streamMock->shouldReceive('consume')->once();

        // Assert that we flash the correct message
        $sessionMock->shouldReceive('flash')->with('status', 'Test Stream fetched 2 new items')->once();

        $controller = new \App\Http\Controllers\StreamController();
        $response = $controller->consume($requestMock, $streamMock);

        // Assert that we are redirected after success
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }
}
