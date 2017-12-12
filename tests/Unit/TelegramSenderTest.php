<?php

class TelegramSenderTest extends TestCase
{
    /**
     * @var \App\Support\PostsCollection
     */
    private $posts;
    /**
     * @var \App\Services\TelegramSender
     */
    private $sender;

    public function setUp()
    {
        $group = new \App\Dto\Group([
            'id' => 1,
            'name' => 'name',
            'screen_name' => 'screen_name'
        ]);

        $post = new \App\Dto\Post([
            'text' => 'text',
            'date' => 321,
            'marked_as_ads' => 0
        ], $group);

        $this->posts = new \App\Support\PostsCollection([$post]);

        $this->sender = new \App\Services\TelegramSender();

        parent::setUp();
    }

    /** @test */
    public function it_returns_post_time()
    {
        $this->withoutJobs();
        $this->assertSame(321, $this->sender->sendPosts(1, $this->posts));
    }

    /** @test */
    public function can_send_posts()
    {
        $this->expectsJobs(\App\Jobs\SendTelegramMessage::class);

        $this->sender->sendPosts(1, $this->posts);
    }
}
