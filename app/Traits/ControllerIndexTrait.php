<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: tino
 * Date: 11/6/16
 * Time: 9:56 AM
 */

trait ControllerIndexTrait {


    public function index(Request $request, $action, $params = null)
    {
        if(method_exists($this, $action))
        {
            return $this->{$action}($request, $params);
        }else{
            abort(404, 'Page not found.');
        }
    }
}