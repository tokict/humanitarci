<?php

namespace App\Providers;

use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\GoodsInput;
use App\Models\LegalEntity;
use App\Models\MonetaryInput;
use App\Models\MonetaryOutput;
use App\Models\Person;
use App\Models\Setting;
use App\Observers\MonetaryInputObserver;
use App\Observers\GoodsInputObserver;
use App\Observers\DonationObserver;
use App\Observers\MonetaryOutputObserver;
use App\Observers\SettingObserver;
use App\Observers\UserObserver;
use App\Observers\CampaignObserver;
use App\Observers\DonorObserver;
use App\Observers\PersonObserver;
use App\Observers\EntityObserver;
use App\Observers\BeneficiaryObserver;
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
        MonetaryOutput::observe(MonetaryOutputObserver::class);
        MonetaryInput::observe(MonetaryInputObserver::class);
        GoodsInput::observe(GoodsInputObserver::class);
        Donation::observe(DonationObserver::class);
        Donor::observe(DonorObserver::class);
        Campaign::observe(CampaignObserver::class);
        Beneficiary::observe(BeneficiaryObserver::class);
        User::observe(UserObserver::class);
        Person::observe(PersonObserver::class);
        LegalEntity::observe(EntityObserver::class);
        Setting::observe(SettingObserver::class);


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
