<?php

namespace Terranet\Administrator;

class DashboardController extends ControllerAbstract
{
    public function index()
    {
        return view(app('scaffold.template')->layout('dashboard'));
    }
}
