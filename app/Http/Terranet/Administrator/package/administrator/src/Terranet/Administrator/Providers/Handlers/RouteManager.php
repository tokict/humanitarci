<?php

namespace Terranet\Administrator\Providers\Handlers;

use Illuminate\Routing\Events\RouteMatched;

class RouteManager
{
    public function handle()
    {
        app('router')->matched(function (RouteMatched $event) {
            $route = $event->route;
            $request = $event->request;

            if ($route->getParameter('module'))
                return true;

            if ($resolver = app('scaffold.config')->get('resource.resolver')) {
                $module = call_user_func_array($resolver, [$route, $request]);
            } else {
                $module = $request->segment(app('scaffold.config')->get('resource.segment', 2));
            }

            $route->setParameter('module', $module);

            return $module;
        });
    }
}