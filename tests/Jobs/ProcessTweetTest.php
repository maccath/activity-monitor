<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProcessTweetTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * Test that the processor saves the tweet as an eloquent model
     */
    public function testTweetProcessed()
    {
        $randomTweetData = $this->createRandomTweetData();
        $processTweet = new \App\Twitter\Jobs\ProcessTweet(json_encode($randomTweetData));

        // Not there yet.
        $this->assertEmpty(\App\Twitter\Tweet::where('id', '=', $randomTweetData['id_str'])->get());

        $processTweet->handle();

        // Now it is!
        $this->assertNotEmpty(\App\Twitter\Tweet::where('id', '=', $randomTweetData['id_str'])->get());
    }

    /**
     * Test that the tweet is not processed if the JSON is invalid
     */
    public function testInvalidJson()
    {
        $this->expectException(Exception::class);

        $processTweet = new \App\Twitter\Jobs\ProcessTweet("{ 'bar': 'baz' }");
        $processTweet->handle();
    }

    /**
     * Test that the tweet is not processed if there is no user data
     */
    public function testNoUserData()
    {
        $randomTweetData = $this->createRandomTweetData();
        unset($randomTweetData['user']);

        $this->assertArrayNotHasKey('user', $randomTweetData);
        $this->expectException(\Exception::class);

        $processTweet = new \App\Twitter\Jobs\ProcessTweet(json_encode($randomTweetData));
        $processTweet->handle();
    }


    /**
     * Test that the tweet is not processed if there is no ID
     */
    public function testNoId()
    {
        $randomTweetData = $this->createRandomTweetData();
        unset($randomTweetData['id']);
        unset($randomTweetData['id_str']);

        $this->assertArrayNotHasKey('id', $randomTweetData);
        $this->assertArrayNotHasKey('id_str', $randomTweetData);
        $this->expectException(\Exception::class);

        $processTweet = new \App\Twitter\Jobs\ProcessTweet(json_encode($randomTweetData));
        $processTweet->handle();
    }

    /**
     * @return array
     */
    private function createRandomTweetData()
    {
        $id = $this->faker->randomNumber();
        $user_id = $this->faker->randomNumber();

        return [
            'created_at' => $this->faker->dateTimeThisMonth->format('D M j H:i:s O Y'),
            'id' => (int) $id,
            'id_str' => (string) $id,
            'text' => $this->faker->realText(140),
            'user' => [
                'id' => (int) $user_id,
                'id_str' => (string) $user_id,
                'screen_name' => $this->faker->userName(),
            ],
        ];
    }
}
