<?php

namespace App\Console\Commands;

use App\Contracts\SenderInterface;
use App\Exceptions\FeedRecordsNotFoundException;
use App\Repositories\UserRepository;
use App\Services\VkFeedService;
use Illuminate\Console\Command;

class CheckFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for news feed';
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var SenderInterface
     */
    private $sender;

    /**
     * Create a new command instance.
     *
     * @param UserRepository  $users
     * @param SenderInterface $sender
     */
    public function __construct(UserRepository $users, SenderInterface $sender)
    {
        $this->users = $users;
        $this->sender = $sender;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \VK\VKException
     */
    public function handle(): void
    {
        $users = $this->users->getEnabledUsers();

        /* @var \App\Entities\User $user */
        foreach ($users as $user) {
            $service = new VkFeedService($user->access_token);
            try {
                $posts = $service->getPosts($user->last_date);
            } catch (FeedRecordsNotFoundException $e) {
                // За указанный период времени не было записей, просто пропускаем.
                continue;
            }

            $postTime = $this->sender->sendPosts($user->telegram_id, $posts);

            $user->updateSeenDate($postTime);
        }
    }
}
