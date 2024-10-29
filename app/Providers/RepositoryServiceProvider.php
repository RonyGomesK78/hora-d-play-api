<?php

namespace App\Providers;

use App\Interfaces\GameRepositoryInterface;
use App\Interfaces\GameEventRepositoryInterface;
use App\Repositories\GameEventRepository;
use App\Repositories\GameRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
        $this->app->bind(GameEventRepositoryInterface::class, GameEventRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
