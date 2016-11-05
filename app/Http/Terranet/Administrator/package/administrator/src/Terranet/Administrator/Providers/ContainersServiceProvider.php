<?php

namespace Terranet\Administrator\Providers;

use Illuminate\Config\Repository as Config;
use Illuminate\Support\ServiceProvider;
use Terranet\Administrator\Actions as ActionsFactory;
use Terranet\Administrator\Columns\Factory as ColumnsFactory;
use Terranet\Administrator\Contracts\Module;
use Terranet\Administrator\Contracts\Module\Filtrable;
use Terranet\Administrator\Contracts\Module\Sortable;
use Terranet\Administrator\Contracts\Services\Actions;
use Terranet\Administrator\Contracts\Services\Finder;
use Terranet\Administrator\Contracts\Services\TemplateProvider;
use Terranet\Administrator\Exception;
use Terranet\Administrator\Filter;
use Terranet\Administrator\Form\Builder as FormFactory;
use Terranet\Administrator\Schema;
use Terranet\Administrator\Services\MagnetParams;
use Terranet\Administrator\Services\Sorter;
use Terranet\Administrator\Services\Template;
use Terranet\Administrator\Services\Widgets;

class ContainersServiceProvider extends ServiceProvider
{
    protected $containers = [
        'AdminConfig' => 'scaffold.config',
        'AdminResource' => 'scaffold.module',
        'AdminModel' => 'scaffold.model',
        'AdminWidget' => 'scaffold.widget',
        'AdminSchema' => 'scaffold.schema',
        'AdminSortable' => 'scaffold.sortable',
        'AdminFilter' => 'scaffold.filter',
        'AdminColumns' => 'scaffold.columns',
        'AdminActions' => 'scaffold.actions',
        'AdminTemplate' => 'scaffold.template',
        'AdminForm' => 'scaffold.form',
        'AdminMagnet' => 'scaffold.magnet',
        'AdminFinder' => 'scaffold.finder',
        'AdminBreadcrumbs' => 'scaffold.breadcrumbs',
        'AdminNavigation' => 'scaffold.navigation',
    ];

    public function register()
    {
        foreach (array_keys($this->containers) as $container) {
            $method = "register{$container}";

            call_user_func_array([$this, $method], []);
        }

        $this->app->bind(Module::class, function ($app) {
            return $app['scaffold.module'];
        });
    }

    protected function registerAdminConfig()
    {
        $this->app->singleton('scaffold.config', function ($app) {
            $config = $app['config']['administrator'];

            return new Config((array) $config);
        });
    }

    protected function registerAdminResource()
    {
        $this->app->singleton('scaffold.module', function ($app) {
            if (in_array($app['router']->currentRouteName(), ['scaffold.settings.edit', 'scaffold.settings.update'])) {
                return $app['scaffold.module.settings'];
            }

            if (! ($router = $app['router']->current()) || $app->runningInConsole()) {
                return null;
            }

            if ($module = $router->parameter('module')) {
                try {
                    return $app["scaffold.module.{$module}"];
                } catch (\Exception $e) {
                    return null;
                }
            }

            return null;
        });
    }

    protected function registerAdminModel()
    {
        $this->app->singleton('scaffold.model', function ($app) {
            if (($finder = app('scaffold.finder')) && ($id = $app['router']->current()->parameter('id'))) {
                return $finder->find($id);
            }

            return null;
        });
    }

    protected function registerAdminWidget()
    {
        $this->app->singleton('scaffold.widget', function ($app) {
            if ($module = $app['scaffold.module']) {
                return new Widgets($module->widgets());
            }

            return null;
        });
    }

    protected function registerAdminSchema()
    {
        $this->app->singleton('scaffold.schema', function ($app) {
            if ($schema = $app['db']->connection()->getDoctrineSchemaManager()) {
                // fix dbal missing types
                $platform = $schema->getDatabasePlatform();
                $platform->registerDoctrineTypeMapping('enum', 'string');
                $platform->registerDoctrineTypeMapping('set', 'string');

                return new Schema($schema);
            }

            return null;
        });
    }

    protected function registerAdminSortable()
    {
        $this->app->singleton('scaffold.sortable', function ($app) {
            if ($module = $app['scaffold.module']) {
                return new Sorter(
                    $module instanceof Sortable ? $module->sortable() : [],
                    method_exists($module, 'sortDirection') ? $module->sortDirection() : 'desc'
                );
            }

            return null;
        });
    }

    protected function registerAdminColumns()
    {
        $this->app->singleton('scaffold.columns', function ($app) {
            if ($module = $app['scaffold.module']) {
                return new ColumnsFactory($module->columns());
            }

            return null;
        });
    }

    protected function registerAdminActions()
    {
        $this->app->singleton('scaffold.actions', function ($app) {
            if ($module = $app['scaffold.module']) {
                $handler = $module->actions();
                $handler = new $handler($module);

                if (! $handler instanceof Actions) {
                    throw new Exception('Actions handler must implement ' . Actions::class . ' contract');
                }

                return new ActionsFactory($handler, $module);
            }

            return null;
        });
    }

    protected function registerAdminTemplate()
    {
        $this->app->singleton('scaffold.template', function ($app) {
            // check for resource template
            $handler = ($module = $app['scaffold.module']) ? $module->template() : Template::class;
            $handler = new $handler();

            if (! $handler instanceof TemplateProvider) {
                throw new Exception('Templates handler must implement ' . TemplateProvider::class . ' contract');
            }

            return $handler;
        });
    }

    protected function registerAdminForm()
    {
        $this->app->singleton('scaffold.form', function ($app) {
            if ($module = $app['scaffold.module']) {
                return new FormFactory($module->form());
            }

            return null;
        });
    }

    protected function registerAdminMagnet()
    {
        $this->app->singleton('scaffold.magnet', function ($app) {
            if ($module = $app['scaffold.module']) {
                return new MagnetParams($app['request'], $module->magnetParams());
            }

            return null;
        });
    }

    protected function registerAdminFilter()
    {
        $this->app->singleton('scaffold.filter', function ($app) {
            if ($module = $app['scaffold.module']) {
                $filters = $module instanceof Filtrable ? $module->filters() : [];
                $scopes = $module instanceof Filtrable ? $module->scopes() : [];

                return new Filter($app['request'], $filters, $scopes);
            }

            return null;
        });
    }

    protected function registerAdminFinder()
    {
        $this->app->singleton('scaffold.finder', function ($app) {
            if ($module = $app['scaffold.module']) {
                $finder = $module->finder();
                $finder = new $finder($module);

                if (! $finder instanceof Finder) {
                    throw new Exception('Items Finder must implement ' . Finder::class . ' contract');
                }

                return $finder;
            }

            return null;
        });
    }

    protected function registerAdminBreadcrumbs()
    {
        $this->app->singleton('scaffold.breadcrumbs', function ($app) {
            if ($module = $app['scaffold.module']) {
                $provider = $module->breadcrumbs();

                return new $provider($app->make('breadcrumbs'), $app->make('scaffold.module'));
            }

            return null;
        });
    }

    protected function registerAdminNavigation()
    {
        $this->app->singleton('scaffold.navigation', function ($app) {
            $menu = $app['scaffold.config']->get('menu', function () {
            });

            return call_user_func($menu);
        });
    }
}
