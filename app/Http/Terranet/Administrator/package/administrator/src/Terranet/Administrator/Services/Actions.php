<?php

namespace Terranet\Administrator\Services;

use Illuminate\Database\Eloquent\Model;
use Terranet\Administrator\Contracts\Services\Actions as ActionsContract;
use Terranet\Administrator\Contracts\Services\Saver;
use Terranet\Administrator\Exception;
use Terranet\Administrator\Requests\UpdateRequest;
use Terranet\Administrator\Traits\ExportsCollection;

class Actions implements ActionsContract
{
    use ExportsCollection;

    protected static $responses = [];

    /**
     * Update item callback.
     *
     * @param               $eloquent
     * @param UpdateRequest $request
     *
     * @return string
     *
     * @throws Exception
     *
     * @internal param $repository
     */
    public function save($eloquent, UpdateRequest $request)
    {
        $saver = app('scaffold.module')->saver();
        $saver = new $saver($eloquent, $request);

        if (!$saver instanceof Saver) {
            throw new Exception('Saver must implement '.Saver::class.' contract');
        }

        return $saver->sync();
    }

    /**
     * Destroy an attachment.
     *
     * @param   $item
     * @param   $attachment
     *
     * @return bool
     */
    public function detachFile(Model $item, $attachment)
    {
        try {
            $item->$attachment = STAPLER_NULL;
            $item->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Remove selected collection.
     *
     * @param       $eloquent
     * @param array $collection
     *
     * @global
     *
     * @return $this
     */
    public function removeSelected(Model $eloquent, array $collection = [])
    {
        return $eloquent->newQueryWithoutScopes()->whereIn('id', $collection)->get()->each(function ($item) {
            return $this->authorize('delete', $item) ? $this->delete($item) : $item;
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param string $method
     * @param        $item
     * @param null   $module
     *
     * @return bool
     */
    public function authorize($method, $item = null, $module = null)
    {
        if (is_null($item)) {
            $item = app('scaffold.module')->model();
        }

        return $this->getCachedResponse($method, $item, $module);
    }

    /**
     * Destroy item callback.
     *
     * @param $item
     *
     * @return string
     */
    public function delete(Model $item)
    {
        if (method_exists($item, 'trashed') && $item->trashed()) {
            return $item->forceDelete();
        }

        return $item->delete();
    }

    /**
     * @param $method
     * @param $item
     * @param null $module
     *
     * @return bool|mixed
     */
    protected function getCachedResponse($method, $item, $module = null)
    {
        $method = 'can'.title_case($method);

        if (!$module) {
            $module = app('scaffold.module');
        }

        $key = $method.'_'.class_basename($item).'_'.md5(serialize($item)).'_'.class_basename($module);

        if (!array_key_exists($key, static::$responses)) {
            $response = method_exists($this, $method)
                ? call_user_func_array([$this, $method], [auth('admin')->user(), $item])
                : true;

            static::$responses[$key] = $response;
        }

        return static::$responses[$key];
    }
}
