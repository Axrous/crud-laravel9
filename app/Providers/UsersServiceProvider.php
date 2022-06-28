<?php

namespace App\Providers;

use App\Models\Users;
use App\Repository\UsersRepository;
use App\Services\Impl\UsersServiceImpl;
use App\Services\UsersService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider implements DeferrableProvider
{
    
    public array $singletons = [
        UsersService::class => UsersServiceImpl::class,
    ];

    public function provides()
    {
        return [UsersService::class, Users::class, UsersRepository::class];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Users::class, function($app) {
            return new Users();
        });

        $this->app->singleton(UsersRepository::class, function($app) {
            return new UsersRepository($app->make(Users::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
