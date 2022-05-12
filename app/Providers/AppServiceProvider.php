<?php

namespace App\Providers;

use App\Adapters\HttpClient;
use App\Adapters\HttpClientInterface;
use App\Repositories\AuthorizationRepository;
use App\Repositories\Interfaces\AuthorizationRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\NotificationRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
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
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );
        $this->app->bind(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );
        $this->app->bind(
            AuthorizationRepositoryInterface::class,
            AuthorizationRepository::class
        );
        $this->app->bind(
            HttpClientInterface::class,
            HttpClient::class
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
