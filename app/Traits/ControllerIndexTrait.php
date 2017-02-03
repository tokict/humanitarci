<?php

namespace App\Traits;

use Illuminate\Support\Facades\Input;
use Request;
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
    protected $page;
    protected $input;


    public function index(\Illuminate\Http\Request $request, $full = true)
    {

        $requestRoute = Route::current();
        $routeArray = $requestRoute->getAction();
        $this->action = !empty(Route::current()->parameters()['action']) ? Route::current()->parameters()['action'] : null;
        $controllerAction = class_basename($routeArray['controller']);
        $this->controller = explode('@', $controllerAction)[0];
        $this->params = $requestRoute->parameters();
        if (Request::isMethod('get')) {
            $this->input = Input::all();
        }

        if ($requestRoute->getPrefix() != "/admin") {
            if (!Request::ajax()) {
                $this->action = Lang::get('routes.actions.' . $this->action, [], '');
            }

        } else {
            if (Gate::denies($this->controller, [$this->params])) {
                abort(403, 'You do not have permission to access this resource');
            }
        }

        $this->page = new \stdClass();
        $this->page->description = env('PROJECT_DESCRIPTION');
        $this->page->title = env('PROJECT_TITLE');
        $this->page->url = env('APP_URL');
        $this->page->image = env('PROJECT_LOGO');

        View::share(['controller' => $this->controller, 'action' => $this->action, 'params' => $this->params, 'page' => $this->page, 'input' => $this->input]);

        if ($full) {
            $params = isset($this->params['params']) ? $this->params['params'] : null;

            if (method_exists($this, 'initialize')) {
                $this->{'initialize'}($request, $params);
            }

            if (method_exists($this, $this->action)) {
                return $this->{$this->action}($request, $params);
            } else {
                abort(404, 'Page not found.');
            }
        }
    }
}