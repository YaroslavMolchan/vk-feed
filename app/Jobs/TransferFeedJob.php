<?php

namespace App\Jobs;

class TransferFeedJob extends Job
{
    /**
     * @author MY
     * @var
     */
    private $method;
    /**
     * @author MY
     * @var
     */
    private $params;

    /**
     * Create a new job instance.
     *
     * @param $method
     * @param $params
     */
    public function __construct($method, $params)
    {
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_BOT_API'));

        call_user_func_array([$bot, $this->method], $this->params);
    }
}
