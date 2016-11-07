<?php

use App\User;
use Pingpong\Menus\MenuBuilder;
use Terranet\Administrator\Contracts\Module\Navigable;

return [
    'prefix' => 'admin',
    'title' => "<b>Admin</b> Architect",
    'auth_identity' => 'email',
    'auth_credential' => 'password',
    'auth_model' => User::class,
    'assets_path' => 'administrator',
    'path' => [
        'module' => "Http/Terranet/Administrator/Modules",
        'action' => "Http/Terranet/Administrator/Actions",
        'panel' => "Http/Terranet/Administrator/Dashboard",
        'finder' => "Http/Terranet/Administrator/Finders",
        'saver' => "Http/Terranet/Administrator/Savers",
        'column' => "Http/Terranet/Administrator/Decorators",
        'template' => "Http/Terranet/Administrator/Templates",
        'widget' => "Http/Terranet/Administrator/Widgets",
        'badge' => "Http/Terranet/Administrator/Badges",
        'breadcrumbs' => "Http/Terranet/Administrator/Breadcrumbs",
    ],
    'manage_passwords' => true,
    'gravatar' => true,
    /**
     * Basic user validation
     */
    'permission' => function () {
        if (auth('admin')->guest()) {
            return false;
        }

        $user = auth('admin')->user();

        return !empty($user->id);
    },
    /**
     * The menu item that should be used as the default landing page of the administrative section
     *
     * @type string
     */
    'home_page' => 'admin/users',
    /**
     * Navigation
     * each Navigable Resource will be added to navigation automatically
     */
    'menu' => function () {
        if ($navigation = app('menus')) {
            /**
             * Sidebar navigation
             */
            $navigation->create(Navigable::MENU_SIDEBAR, function (MenuBuilder $sidebar) {
                // Dashboard
                $sidebar->route('scaffold.dashboard', trans('administrator::module.dashboard'), [], 1, [
                    'id' => 'dashboard',
                    'icon' => 'fa fa-dashboard',
                ]);

                // Create new users group
                $sidebar->dropdown(trans('administrator::module.groups.users'), function ($sub) {
                    $sub->route('scaffold.create', trans('administrator::buttons.create_item', ['resource' => 'User']), ['module' => 'users'], 1, []);
                }, 2, ['id' => 'groups', 'icon' => 'fa fa-group']);
            });

            /**
             * Tools navigation
             */
            $navigation->create(Navigable::MENU_TOOLS, function (MenuBuilder $tools) {
                $tools->url(
                    'admin/logout',
                    trans('administrator::buttons.logout'),
                    100,
                    ['icon' => 'glyphicon glyphicon-log-out']
                );
            });
        }

        return $navigation;
    },

    'resource' => [
        /**
         * The custom way to resolve module name for custom resources
         * when controller missing Router's $module parameter
         */
        'resolver' => null,

        /**
         * Default segment for module name resolver
         * /admin/pages - admin => 1, pages => 2
         */
        'segment' => 2,
    ],

    'cache' => [
        /**
         * Cache Eloquent Relations for better performance
         * $relations mixed integer|null TTL in minutes or null to disable
         */
        'relations' => 1,
    ],
];
