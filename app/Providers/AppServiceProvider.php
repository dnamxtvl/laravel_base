<?php

namespace App\Providers;

use App\Data\Repository\ChatRepository;
use App\Data\Repository\UserBlockRepository;
use App\Data\Repository\UserRepository;
use App\Domains\Chat\Repository\ChatRepositoryInterface;
use App\Domains\User\Repository\UserBlockRepositoryInterface;
use App\Domains\User\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(ChatRepositoryInterface::class, ChatRepository::class);
        $this->app->singleton(UserBlockRepositoryInterface::class, UserBlockRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
