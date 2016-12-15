<?php

namespace App\Providers;

use App\Models\Donation;
use App\Models\GoodsInput;
use App\Models\MonetaryInput;
use App\Observers\MonetaryInputObserver;
use App\Observers\GoodsInputObserver;
use App\Observers\DonationObserver;
use App\Observers\UserObserver;
use App\User;
use Carbon\Carbon;
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
        Carbon::setLocale(env('LANGUAGE'));

        MonetaryInput::observe(MonetaryInputObserver::class);
        GoodsInput::observe(GoodsInputObserver::class);
        Donation::observe(DonationObserver::class);
        User::observe(UserObserver::class);


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
