<?php

namespace Terranet\Administrator;

use Illuminate\Http\Request;
use Terranet\Administrator\Contracts\Module;
use Terranet\Administrator\Middleware\Authenticate;
use Terranet\Administrator\Middleware\AuthProvider;
use Terranet\Administrator\Middleware\Resources;

class BatchController extends ControllerAbstract
{
    /**
     * Perform a batch action against selected collection.
     *
     * @param         $page
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function batch($page, Request $request)
    {
        $this->authorize($action = $request->get('batch_action'), $model = app('scaffold.module')->model());

        $this->rememberPreviousPage();

        $response = app('scaffold.actions')->exec($action, [$model, $request->get('collection', [])]);

        if ($response instanceof \Illuminate\Contracts\Support\Renderable) {
            return $response;
        }

        return redirect()->to($this->getPreviousUrl())->with(
            'messages',
            [trans('administrator::messages.action_success')]
        );
    }

    /**
     * Export collection.
     *
     * @param $page
     * @param $format
     *
     * @return mixed
     */
    public function export($page, $format)
    {
        $this->authorize('index', app('scaffold.module')->model());

        $this->rememberPreviousPage();

        $query = app('scaffold.finder')->getQuery();

        return app('scaffold.actions')->exec('export', [$query, $format]);
    }
}
