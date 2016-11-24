<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/**
 * Created by PhpStorm.
 * User: tino
 * Date: 11/6/16
 * Time: 9:56 AM
 */
trait ControllerIndexTrait
{
    protected $controller;
    protected $action;
    protected $params;

    public function __construct()
    {
        $request = Route::current();
        $routeArray = $request->getAction();
        $this->action = !empty(Route::current()->parameters()['action'])?Route::current()->parameters()['action']:null;
        $controllerAction = class_basename($routeArray['controller']);
        $this->controller = explode('@', $controllerAction)[0];
        $this->params = $request->parameters();


        if ($request->getPrefix() != "/admin") {
            $this->action = Lang::get('routes.actions.' . $this->action, [], '');

        } else {
            if (Gate::denies($this->controller, [$this->params])) {
                abort(403, 'You do not have permission to access this resource');
            }
        }

        View::share(['controller' => $this->controller, 'action' => $this->action, 'params' => $this->params]);
    }

    public function index(Request $request)
    {




        if (method_exists($this, $this->action)) {
            return $this->{$this->action}($request, $this->params['params']);
        } else {
            abort(404, 'Page not found.');
        }
    }
}