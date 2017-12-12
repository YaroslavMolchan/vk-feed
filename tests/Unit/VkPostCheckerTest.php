<?php

class VkPostCheckerTest extends TestCase
{
    /**
     * @var \App\Dto\Group
     */
    private $group;
    /**
     * @var \App\Dto\Post
     */
    private $post;
    /**
     * @var \App\Support\VkPostChecker
     */
    private $checker;

    public function setUp()
    {
        $this->group = new \App\Dto\Group([
            'id' => 1,
            'name' => 'name',
            'screen_name' => 'screen_name'
        ]);

        $this->post = new \App\Dto\Post([
            'text' => 'text',
            'date' => time(),
            'marked_as_ads' => 0
        ], $this->group);

        $this->checker = new \App\Support\VkPostChecker();

        parent::setUp();
    }

    /** @test */
    public function ads_not_passed_validation()
    {
        $badPost = clone $this->post;
        $badPost->isAds = true;

        $this->assertFalse($this->checker->passes($badPost));
    }

    /** @test */
    public function post_from_blacklist_not_passed_validation()
    {
        $badPost = clone $this->post;
        $badPost->group->id = 34215577;

        $this->assertFalse($this->checker->passes($badPost));
    }

    /** @test */
    public function good_post_passed_validation()
    {
        $this->assertTrue($this->checker->passes($this->post));
    }
}
