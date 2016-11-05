<?php

namespace Terranet\Administrator;

use Illuminate\Database\Eloquent\Model;
use Terranet\Administrator\Contracts\Module;
use Terranet\Administrator\Services\Actions;
use Terranet\Administrator\Services\Breadcrumbs;
use Terranet\Administrator\Services\Finder;
use Terranet\Administrator\Services\Saver;
use Terranet\Administrator\Services\Template;
use Terranet\Administrator\Traits\Module\AllowsNavigation;
use Terranet\Administrator\Traits\Module\DetectsCommentFlag;
use Terranet\Administrator\Traits\Module\HasColumns;
use Terranet\Administrator\Traits\Module\HasWidgets;

class Resource implements Module
{
    use AllowsNavigation, DetectsCommentFlag, HasColumns, HasWidgets;

    /**
     * The module Eloquent model.
     *
     * @return mixed
     */
    protected $model;

    /**
     * Breadcrumbs provider.
     *
     * @var
     */
    protected $breadcrumbs = Breadcrumbs::class;

    /**
     * Service layer responsible for searching items.
     *
     * @var
     */
    protected $finder = Finder::class;

    /**
     * Service layer responsible for persisting request.
     *
     * @var
     */
    protected $saver = Saver::class;

    /**
     * Actions manager class.
     *
     * @var
     */
    protected $actions = Actions::class;

    /**
     * View templates provider.
     *
     * @var
     */
    protected $template = Template::class;

    /**
     * Query string parameters that should be appended to whole links and forms.
     *
     * @var array
     */
    protected $magnetParams = [];

    /**
     * Include or not columns of Date type in index listing.
     *
     * @var bool
     */
    protected $includeDateColumns = false;

    /**
     * The module Eloquent model.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function getModelClass()
    {
        if (list(/*$flag*/, $value) = $this->hasCommentFlag('model')) {
            return $value;
        }

        if (!$model = $this->model) {
            throw new \Exception('No resource model defined');
        }

        return $model;
    }

    /**
     * The module Templates manager.
     *
     * @return string
     */
    public function template()
    {
        if (class_exists($file = $this->getQualifiedClassNameOfType('Templates'))) {
            return $file;
        }

        if (list(/*$flag*/, $value) = $this->hasCommentFlag('template')) {
            return $value;
        };

        return $this->template;
    }

    /**
     * @return Model
     */
    public function model()
    {
        static $model = null;

        if (null === $model) {
            $class = $this->getModelClass();
            $model = new $class();
        }

        return $model;
    }

    /**
     * Define the class responsive for fetching items.
     *
     * @return mixed
     */
    public function finder()
    {
        if (class_exists($file = $this->getQualifiedClassNameOfType('Finders'))) {
            return $file;
        }

        if (list(/*$flag*/, $value) = $this->hasCommentFlag('finder')) {
            return $value;
        };

        return $this->finder;
    }

    /**
     * Define the class responsive for persisting items.
     *
     * @return mixed
     */
    public function saver()
    {
        if (class_exists($file = $this->getQualifiedClassNameOfType('Savers'))) {
            return $file;
        }

        if (list(/*$flag*/, $saver) = $this->hasCommentFlag('saver')) {
            return $saver;
        };

        return $this->saver;
    }

    /**
     * Breadcrumbs provider
     * First parse Module doc block for provider declaration.
     *
     * @return mixed
     */
    public function breadcrumbs()
    {
        if (class_exists($file = $this->getQualifiedClassNameOfType('Breadcrumbs'))) {
            return $file;
        }

        if (list(/*$flag*/, $value) = $this->hasCommentFlag('breadcrumbs')) {
            return $value;
        };

        return $this->breadcrumbs;
    }

    /**
     * Define the Actions provider - object responsive for
     * CRUD operations, Export, etc...
     * as like as checks action permissions.
     *
     * @return mixed
     */
    public function actions()
    {
        if (class_exists($file = $this->getQualifiedClassNameOfType('Actions'))) {
            return $file;
        }

        if (list(/*$flag*/, $value) = $this->hasCommentFlag('actions')) {
            return $value;
        };

        return $this->actions;
    }

    /**
     * Return magnet params.
     *
     * @return array
     */
    public function magnetParams()
    {
        return (array) $this->magnetParams;
    }

    /**
     * Get the full path to class of special type.
     *
     * @param $type
     *
     * @return string
     */
    protected function getQualifiedClassNameOfType($type)
    {
        return app()->getNamespace()."Http\\Terranet\\Administrator\\{$type}\\".class_basename($this);
    }
}
