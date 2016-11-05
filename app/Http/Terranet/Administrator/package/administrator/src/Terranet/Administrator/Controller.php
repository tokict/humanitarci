<?php

namespace Terranet\Administrator;

use Terranet\Administrator\Contracts\Module;
use Terranet\Administrator\Middleware\Authenticate;
use Terranet\Administrator\Middleware\AuthProvider;
use Terranet\Administrator\Middleware\Resources;
use Terranet\Administrator\Requests\UpdateRequest;
use Terranet\Administrator\Services\Widgets\AbstractWidget;
use Terranet\Administrator\Services\Widgets\EloquentWidget;
use URL;

class Controller extends ControllerAbstract
{
    /**
     * @param        $page
     * @param Module $resource
     *
     * @return \Illuminate\View\View
     */
    public function index($page, Module $resource)
    {
        $this->authorize('index', $resource->model());

        $items = app('scaffold.finder')->fetchAll();

        return view(app('scaffold.template')->index('index'), ['items' => $items]);
    }

    /**
     * View resource.
     *
     * @param $page
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function view($page, $id)
    {
        $this->authorize('view', $eloquent = app('scaffold.model'));

        $this->rememberPreviousPage();

        app('scaffold.widget')->add(
            (new EloquentWidget($eloquent))
                ->setOrder(0)
                ->setTab(AbstractWidget::TAB_DEFAULT)
                ->setPlacement('model')
        );

        return view(app('scaffold.template')->view('index'), [
            'item' => $eloquent,
        ]);
    }

    /**
     * Edit resource.
     *
     * @param $page
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($page, $id)
    {
        $this->authorize('update', $eloquent = app('scaffold.model'));

        $this->rememberPreviousPage();

        return view(app('scaffold.template')->edit('index'), [
            'item' => $eloquent,
        ]);
    }

    /**
     * @param                    $page
     * @param                    $id
     * @param UpdateRequest|null $request
     *
     * @return mixed
     */
    public function update($page, $id, UpdateRequest $request = null)
    {
        $this->authorize('update', $eloquent = app('scaffold.model'));

        app('scaffold.actions')->exec('save', [$eloquent, $request]);

        return $this->redirectTo($page, $id)->with('messages', [trans('administrator::messages.update_success')]);
    }

    /**
     * Create new item.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', app('scaffold.module')->model());

        return view(app('scaffold.template')->edit('index'));
    }

    /**
     * Store new item.
     *
     * @param                    $page
     * @param UpdateRequest|null $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($page, UpdateRequest $request = null)
    {
        $this->authorize('create', $eloquent = app('scaffold.module')->model());

        $eloquent = app('scaffold.actions')->exec('save', [$eloquent, $request]);

        return $this->redirectTo($page, $eloquent->id)->with(
            'messages',
            [trans('administrator::messages.create_success')]
        );
    }

    /**
     * Destroy item.
     *
     * @param Module $module
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Module $module)
    {
        $this->authorize('delete', $eloquent = app('scaffold.model'));

        $id = $eloquent->id;

        app('scaffold.actions')->exec('delete', [$eloquent]);

        $message = trans('administrator::messages.remove_success');

        if (URL::previous() == route('scaffold.view', ['module' => $module, 'id' => $id])) {
            return redirect()->to($this->getPreviousUrl())->with('messages', [$message]);
        }

        return redirect()->back()->with('messages', [$message]);
    }

    /**
     * Destroy attachment.
     *
     * @param $page
     * @param $id
     * @param $attachment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAttachment($page, $id, $attachment)
    {
        $this->authorize('update', $eloquent = app('scaffold.model'));

        app('scaffold.actions')->exec('detachFile', [$eloquent, $attachment]);

        return redirect()->back()->with('messages', [trans('administrator::messages.remove_success')]);
    }

    /**
     * Custom action related to item.
     *
     * @param $page
     * @param $id
     * @param $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action($page, $id, $action)
    {
        $this->authorize($action, $eloquent = app('scaffold.model'));

        $this->rememberPreviousPage();

        app('scaffold.actions')->exec($action, [$eloquent]);

        return redirect()->to($this->getPreviousUrl())->with(
            'messages',
            [trans('administrator::messages.action_success')]
        );
    }
}
