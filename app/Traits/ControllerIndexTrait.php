<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

/**
 * Created by PhpStorm.
 * User: tino
 * Date: 11/6/16
 * Time: 9:56 AM
 */

trait ControllerIndexTrait {


    public function index(Request $request, $action, $params = null)
    {
        if($request->route()->getPrefix() != "/admin") {
            $action = Lang::get('routes.actions.' . $action, [], '');
        }
        $routeArray = $request->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);
        $controller =  explode('@', $controllerAction)[0];



        if (Gate::denies($controller, [$this->User, $controller, $action, $params])) {
            abort(403, 'You do not have permission to access this resource');
        }

        if(method_exists($this, $action))
        {
            return $this->{$action}($request, $params);
        }else{
            abort(404, 'Page not found.');
        }
    }
}