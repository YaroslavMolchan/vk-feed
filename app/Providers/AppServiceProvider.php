<?php

namespace App\Providers;

use App\Contracts\SenderInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Services\TelegramSender;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        else {
            $this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
            $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);
        }
        $this->app->register(\Prettus\Repository\Providers\LumenRepositoryServiceProvider::class);

        $this->app->bind(SenderInterface::class, TelegramSender::class);
        // Repositories.
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
    }
}
