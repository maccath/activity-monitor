<?php

class GithubStreamTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    /** @var \App\GitHub\ActivityStreams\GithubStream */
    private $githubStream;

    /** @var string fake GitHub API response body */
    private $fakeResponseBody;

    public function setUp()
    {
        parent::setUp();

        $client = $this->getMockBuilder(\GuzzleHttp\Client::class)
          ->disableOriginalConstructor()
          ->setMethods(['get'])
          ->getMock();

        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
          ->disableOriginalConstructor()
          ->setMethods(['getBody'])
          ->getMock();

        $this->fakeResponseBody = $this->getMockBuilder(\GuzzleHttp\Psr7\Stream::class)
          ->disableOriginalConstructor()
          ->setMethods(['getContents'])
          ->getMock();

        $client->method('get')->willReturn($response);
        $response->method('getBody')->willReturn($this->fakeResponseBody);

        $this->githubStream = new \App\GitHub\ActivityStreams\GithubStream($client);
    }

    public function testImplementsPeriodicStream()
    {
        $this->assertInstanceOf(\App\ActivityStreams\PeriodicStreamInterface::class, $this->githubStream);
    }

    public function testFetchGetsLatestItems()
    {
        $this->fakeResponseBody->method('getContents')->willReturn($this->getFakeGithubActivity());

        // First consume, all items
        $this->githubStream->consume();
        $this->assertNotEmpty($this->githubStream->getItems());

        // Second consume, shouldn't be any items left to consume!
        $this->githubStream->consume();
        $this->assertEmpty($this->githubStream->getItems());
    }

    public function testNewActivityDispatchesJob()
    {
        $this->fakeResponseBody->method('getContents')->willReturn($this->getFakeGithubActivity());

        $this->expectsJobs([\App\GitHub\Jobs\ProcessActivity::class]);

        $this->githubStream->consume();
    }

    public function getFakeGithubActivity()
    {
        return '[
          {
            "type": "Event",
            "public": true,
            "payload": {
            },
            "repo": {
              "id": 3,
              "name": "octocat/Hello-World",
              "url": "https://api.github.com/repos/octocat/Hello-World"
            },
            "actor": {
              "id": 1,
              "login": "octocat",
              "gravatar_id": "",
              "avatar_url": "https://github.com/images/error/octocat_happy.gif",
              "url": "https://api.github.com/users/octocat"
            },
            "org": {
              "id": 1,
              "login": "github",
              "gravatar_id": "",
              "url": "https://api.github.com/orgs/github",
              "avatar_url": "https://github.com/images/error/octocat_happy.gif"
            },
            "created_at": "2011-09-06T17:26:27Z",
            "id": "12345"
          }
        ]';
    }
}
