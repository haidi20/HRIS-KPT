<?php

namespace App\Providers;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Define the isActive function
        Route::macro('isActive', function ($routeName) {
            return Str::startsWith(Route::currentRouteName(), $routeName) ? 'active' : '';
        });
    }
}
