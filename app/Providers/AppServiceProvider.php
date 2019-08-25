<?php

namespace App\Providers;

use App\Edgar\Activity\Repositories\ActivityRepository;
use App\Edgar\Activity\Repositories\Interfaces\ActivityRepositoryInterface;
use App\Edgar\Todo\Repositories\Interfaces\TodoRepositoryInterface;
use App\Edgar\Todo\Repositories\TodoRepository;
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
        $this->app->bind(
            TodoRepositoryInterface::class,
            TodoRepository::class
        );

        $this->app->bind(
            ActivityRepositoryInterface::class,
            ActivityRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
