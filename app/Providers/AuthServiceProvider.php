<?php

namespace App\Providers;

use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Group;
use App\Models\LegalEntity;
use App\Models\Organization;
use App\Models\Person;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);
        //ADMIN

        //Forbid only top level resources like controllers and actions. All model operations need to be
        //managed on the model itself
        $gate->define('CampaignController', function ($user,  $params) {

            if (!$user->super_admin && !$user->admin) {
                return false;
            }

            if ($user->super_admin) {
                return true;
            }else{
                if($params['action'] == 'edit') {
                $campaign = Campaign::whereId((int)$params['params'])->get()->first();
                return isset($user->admin->organization) && $user->admin->organization->id == $campaign->organization->id;
            }


                return true;
            }
            return false;
        });


        $gate->define('BeneficiaryController', function ($user,  $params) {

            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }else{
                if($params['action'] == 'edit'){
                    $beneficiary = Beneficiary::whereId((int) $params['params'])->get()->first();;
                    return isset($user->admin->organization) && $user->admin->organization->id == $beneficiary->creator->admin->organization->id ;
                }
                return true;
            }
            return false;
        });


        $gate->define('GroupController', function ($user,  $params) {

            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }else{
                if($params['action'] == 'edit'){
                    $beneficiary = Group::whereId((int) $params['params'])->get()->first();;
                    return isset($user->admin->organization) && $user->admin->organization->id == $beneficiary->creator->admin->organization->id ;
                }
                return true;
            }
            return false;
        });


        $gate->define('BankController', function ($user,  $params) {

            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }else{

                return false;
            }
            return false;
        });

        $gate->define('UserController', function ($user, $params) {

            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }else{
                return false;
            }

            //Default security false
            return false;
        });
        $gate->define('AdminController', function ($user, $params) {

            if (!$user->super_admin && !$user->admin) {
                return false;
            }


            return true;
        });


        $gate->define('PersonController', function ($user, $params) {

            if ($user->super_admin) {
                return true;
            }else{
                return false;
            }
            return false;
        });

        $gate->define('SettingsController', function ($user, $params) {

            if ($user->super_admin) {
                return true;
            }else{
                return false;
            }
            return false;
        });


        $gate->define('LogController', function ($user, $params) {


            if ($user->super_admin) {
                return true;
            }else{
                return false;
            }
            return false;
        });


        $gate->define('AjaxController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->super_admin) {
                return true;
            }
            return true;
        });


        $gate->define('LegalEntityController', function ($user, $params) {
            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }


            return false;
        });

        $gate->define('OrganizationController', function ($user, $params) {
            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }else{
                if($params['action'] == 'edit'){
                    $organization = Organization::find((int) $params['params'])->first();
                    return isset($user->admin->organization) && $user->admin->organization->id == $organization->id?true:false;
                }
                return true;
            }
            return false;
        });

        $gate->define('DonationController', function ($user, $params) {
            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }else{
                    if(isset($params['params'])) {
                        $donation = Donation::whereId((int)$params['params'])->get()->first();
                        return isset($user->admin->organization) && $user->admin->organization->id == $donation->organization->id ? true : false;
                    }

                return true;
            }
            return false;
        });

        $gate->define('DonorController', function ($user, $params) {

            return true;
        });


        //FRONTEND
        $gate->define('FileController', function ($user,  $params) {
            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }
            return true;
        });
        $gate->define('BanksController', function ($user, $params) {
            if (!$user->super_admin && !$user->admin) {
                return false;
            }
            if ($user->super_admin) {
                return true;
            }
            return true;
        });


        $gate->define('OrganizationsController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->super_admin) {
                return true;
            }
            return true;
        });

        $gate->define('BeneficiariesController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->super_admin) {
                return true;
            }
            return true;
        });

        $gate->define('CampaignsController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->super_admin) {
                return true;
            }
            return true;
        });

        $this->registerPolicies($gate);
    }
}
