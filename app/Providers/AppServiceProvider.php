<?php

namespace App\Providers;

use App\Interfaces\QuoteManagerInterface;
use App\Interfaces\TokenManagerInterface;
use App\Managers\QuoteManager;
use App\Managers\TokenManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: TokenManagerInterface::class,
            concrete: fn(Application $app) => new TokenManager($app)
        );

        $this->app->singleton(
            abstract: QuoteManagerInterface::class,
            concrete: fn(Application $app) => new QuoteManager($app)
        );
    }
}
