<?php

namespace App\Providers;

use App\Http\Interfaces\Front\CartInterface;
use App\Http\Repository\Front\CartRepository;
use Illuminate\Support\ServiceProvider;

class FrontServesProvider extends ServiceProvider
    {
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CartInterface::class,
            CartRepository::class
        );
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
