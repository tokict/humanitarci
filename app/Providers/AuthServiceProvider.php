<?php

namespace App\Providers;

use App\Models\Beneficiary;
use App\Models\Campaign;
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
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }

            if ($user->isSuperAdmin()) {
                return true;
            }else{
                if($params['action'] == 'edit'){
                    $campaign = Campaign::find((int) $params['params'])->first();
                    return $user->id == $campaign->created_by_id;
                }
                return true;
            }
            return false;
        });


        $gate->define('BeneficiaryController', function ($user,  $params) {
            //Allow all for superadmin

            if ($user->isSuperAdmin()) {
                return true;
            }else{
                if($params['action'] == 'edit'){
                    $beneficiary = Beneficiary::find((int) $params['params'])->first();
                    return $user->id == $beneficiary->created_by_id;
                }
                return true;
            }
            return false;
        });

        $gate->define('BankController', function ($user,  $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }else{

                return false;
            }
            return false;
        });

        $gate->define('UserController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }else{
                return false;
            }

            //Default security false
            return false;
        });
        $gate->define('AdminController', function ($user, $params) {
            //Allow all for superadmin

            return true;
        });


        $gate->define('PersonController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }else{
                return false;
            }
            return false;
        });


        $gate->define('AjaxController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }
            return true;
        });


        $gate->define('LegalEntityController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }


            return false;
        });

        $gate->define('OrganizationController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }else{
                if($params['action'] == 'edit'){
                    $organization = Organization::find((int) $params['params'])->first();
                    return isset($user->organization) && $user->organization->id == $organization->id?true:false;
                }
                return true;
            }
            return false;
        });


        //FRONTEND
        $gate->define('FileController', function ($user,  $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }
            return true;
        });
        $gate->define('BanksController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }
            return true;
        });


        $gate->define('OrganizationsController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }
            return true;
        });

        $gate->define('BeneficiariesController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }
            return true;
        });

        $gate->define('CampaignsController', function ($user, $params) {
            //Allow all for superadmin
            if ($user->isSuperAdmin()) {
                return true;
            }
            return true;
        });

        $this->registerPolicies($gate);
    }
}
