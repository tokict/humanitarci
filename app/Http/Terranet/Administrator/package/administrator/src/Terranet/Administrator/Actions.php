<?php

namespace Terranet\Administrator;

use Coduo\PHPHumanizer\StringHumanizer;
use Terranet\Administrator\Contracts\ActionsManager;
use Terranet\Administrator\Contracts\Module;
use Terranet\Administrator\Contracts\Services\Actions as ActionsService;
use Terranet\Administrator\Traits\MethodsCollector;
use Terranet\Administrator\Traits\Module\DetectsCommentFlag;

class Actions implements ActionsManager
{
    use DetectsCommentFlag, MethodsCollector;

    /**
     * @var Actions
     */
    protected $service;

    /**
     * @var Module
     */
    protected $module;

    /**
     * List of item-related actions.
     *
     * @var array
     */
    protected $actions = null;

    /**
     * List of global actions.
     *
     * @var array
     */
    protected $globalActions = null;

    public function __construct(ActionsService $service, Module $module)
    {
        $this->service = $service;
        $this->module = $module;
    }

    /**
     * Parse madule actions handler for single (per item) actions.
     *
     * @param $model
     *
     * @return array
     */
    public function actions($model)
    {
        return $this->scaffoldActions($model);
    }

    /**
     * Parse handler class for per-item and global actions.
     *
     * @param $model
     *
     * @return array
     */
    protected function scaffoldActions($model)
    {
        $actions = [];

        foreach ($this->collectMethods($this->service) as $method) {
            list(/*$flag*/, $type) = $this->hasCommentFlag('action', $method);
            if ($type) {
                if ($this->authorize($method->getName(), $model)) {
                    $action = 'callback' == $type
                        ? $this->linkableAction($model, $method)
                        : $this->callableAction($model, $method);

                    array_push($actions, $action);
                }
            }
        }

        return $actions;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param string $method
     * @param $model
     *
     * @return bool
     */
    public function authorize($method, $model = null)
    {
        return $this->service->authorize($method, $model, $this->module);
    }

    /**
     * @param $model
     * @param $method
     *
     * @return string
     */
    protected function linkableAction($model, $method)
    {
        return link_to(
            route('scaffold.action', app('scaffold.magnet')->with([
                'module' => $this->module->url(),
                'id' => $model,
                'action' => $this->action($method),
            ])->toArray()),
            $this->title($method)
        );
    }

    /**
     * @param $method
     *
     * @return string
     */
    protected function action($method)
    {
        return snake_case($method->getName(), '-');
    }

    protected function title($method)
    {
        return StringHumanizer::humanize($method->getName());
    }

    /**
     * @param $model
     * @param $method
     *
     * @return mixed
     */
    protected function callableAction($model, $method)
    {
        return call_user_func_array([$this->service, $method->getName()], [$model]);
    }

    public function batch()
    {
        return $this->scaffoldBatch();
    }

    /**
     * Parse handler class for per-item and global actions.
     *
     * @return array
     */
    protected function scaffoldBatch()
    {
        $actions = [];

        foreach ($this->collectMethods($this->service) as $method) {
            list($flag) = $this->hasCommentFlag('global', $method);
            if ($flag && $this->authorize($method->getName())) {
                if (method_exists($this->service, $linkMethod = $method->getName() . "Link")) {
                    $actions[] = call_user_func_array([$this->service, $linkMethod], [
                        $this->module,
                        $this->service,
                        $method
                    ]);
                } else {
                    $actions[] = link_to(route('scaffold.batch', app('scaffold.magnet')->with([
                        'module' => $this->module->url(),
                    ])->toArray()), $this->title($method), [
                        'class' => 'btn btn-link',
                        'data-action' => $method->getName(),
                    ]);
                }
            }
        }

        return $actions;
    }

    /**
     * Call handler method.
     *
     * @param       $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function exec($method, array $arguments = [])
    {
        return call_user_func_array([$this->service, $method], (array) $arguments);
    }
}
