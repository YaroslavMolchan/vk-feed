<?php

namespace App\Console\Commands;

use App\Helpers;
use App\Jobs\TransferFeedJob;
use App\User;
use Carbon\Carbon;
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
        $users = User::where('is_enabled', true)->get();

        foreach ($users as $user) {
            $vk = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'), $user->access_token);
            $vk->setApiVersion(5.64);

            $response = $vk->api('newsfeed.get', [
                'filters'    => 'post',
                'count'      => 100,
                'start_time' => $user->last_date
            ]);

            if (!array_key_exists('response', $response)) {
                return;
            }

            $feeds = $response['response']['items'];

            $groups = collect($response['response']['groups']);

            foreach ($feeds as $key => $feed) {
                $post   = new \App\Api\Vk\Feed\Types\Post($feed, $groups);
                $result = $post->prepare();

                if ($key < 1) {
                    $user->update([
                        'last_date' => $result['date']
                    ]);
                }

                if ($result['is_send'] == true) {
                    $job = (new TransferFeedJob($post->getMethod(), $post->getParams()))->delay(Carbon::now()->addSecond());
                    dispatch($job);
                }
            }
        }

        return;
    }
}
