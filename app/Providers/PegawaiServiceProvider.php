<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PegawaiServiceInterface;
use App\Repositories\PegawaiService;

class PegawaiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PegawaiServiceInterface::class,PegawaiService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}