<?php

namespace App\Console\Commands;

use App\Helpers;
use App\User;
use Illuminate\Console\Command;
use TelegramBot\Api\BotApi;
use VK\VK;

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
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::where('telegram_id', 67852056)->first();
        $vk = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'), $user->access_token);
        $vk->setApiVersion(5.64);

        $response = $vk->api('newsfeed.get', [
            'filters' => 'post',
            'count' => 100,
            'start_time' => $user->last_date
        ]);

        $feeds = $response['response']['items'];

        $groups = $response['response']['groups'];

        foreach ($feeds as $key => $feed) {
            $post = new \App\Api\Vk\Feed\Types\Post($feed);
            $result = $post->prepare($groups[$key]);

            if ($result['is_send'] == true) {
                $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_BOT_API'));
                call_user_func_array([$bot, $post->getMethod()], $post->getParams());
            }
        }

        if (!empty($feeds)) {
            $user->update([
                'last_date' => $result['date']
            ]);
        }

        echo count($feeds) . ' send' . PHP_EOL;
    }
}
