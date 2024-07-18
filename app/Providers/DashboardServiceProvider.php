<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Http\Interfaces\Dashboard\CategoryInterface',
            'App\Http\Repository\Dashboard\CategoriesRepository');


        $this->app->bind('App\Http\Interfaces\Dashboard\ProductsInterface',
            'App\Http\Repository\Dashboard\ProductsRepository');


        $this->app->bind('App\Http\Interfaces\Dashboard\ProfileRepository',
            'App\Http\Repository\Dashboard\ProfileRepository');
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
