<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PegawaiServiceInterface;
use App\Repositories\PegawaiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PegawaiServiceInterface::class, PegawaiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
