<?php

namespace App\Providers;

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
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {



        //Forbid only top level resources like controllers and actions. All model operations need to be
        //managed on the model itself
        $gate->define('CampaignController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('CampaignsController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('BeneficiaryController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('BeneficiariesController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('PersonController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });
        $gate->define('AjaxController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('FileController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });
        $gate->define('BanksController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('LegalEntityController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('OrganizationController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('OrganizationsController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });

        $gate->define('UserController', function ($user, $controller, $action, $params)  {
            //Allow all for superadmin
            //if($user->isSuperAdmin()){return true;}
            return true;//$user->id === $contact->user_id;
        });


        $this->registerPolicies($gate);
    }
}
