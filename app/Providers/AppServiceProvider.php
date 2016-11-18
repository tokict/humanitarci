<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

            App::setLocale(env('LANGUAGE'));


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
