<?php

namespace Terranet\Administrator\Services;

use Terranet\Administrator;
use Terranet\Administrator\Contracts\Module;
use Terranet\Administrator\Contracts\Services\Finder as FinderContract;
use Terranet\Administrator\Filters\Assembler;

class Finder implements FinderContract
{
    /**
     * @var Module
     */
    protected $module;

    /**
     * @var
     */
    protected $model;

    /**
     * Query assembler.
     *
     * @var
     */
    protected $assembler;

    public function __construct(Module $module)
    {
        $this->module = $module;
        $this->model = $module->model();
    }

    /**
     * Fetch all items from repository.
     *
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->getQuery()->paginate($this->perPage());
    }

    /**
     * Build Scaffolding Index page query.
     *
     * @return mixed
     */
    public function getQuery()
    {
        $this->assembler();

        $this->handleFilter();

        $this->handleSortable();

        return $this->assembler()->getQuery();
    }

    /**
     * Get the query assembler object.
     *
     * @return Assembler
     */
    protected function assembler()
    {
        if (null === $this->assembler) {
            $this->assembler = (new Assembler($this->model));
        }

        return $this->assembler;
    }

    protected function handleFilter()
    {
        if ($filter = app('scaffold.filter')) {
            if ($filters = $filter->filters()) {
                $this->assembler()->filters($filters);
            }

            if ($magnet = app('scaffold.magnet')) {
                $magnet = $this->removeDuplicates($magnet, $filters);

                $this->handleMagnetFilter($magnet);
            }

            if ($scopes = $filter->scopes()) {
                if (($scope = $filter->scope()) && ($found = $scopes->get($scope))) {
                    $this->assembler()->scopes(
                        $found
                    );
                }
            }
        }
    }

    /**
     * Solving problem then magnet params gets used for auto-filtering
     * even if there is another filter defined with the same name
     *
     * @param $magnet
     * @param $filters
     * @return array
     */
    protected function removeDuplicates($magnet, $filters)
    {
        $magnetKeys = $magnet->toArray();

        foreach ($filters as $filter) {
            if (array_has($magnetKeys, $filter->getName())) {
                unset($magnetKeys[$filter->getName()]);
            }
        }

        $class = get_class(app('scaffold.magnet'));

        return new $class(app('request'), $magnetKeys);
    }

    /**
     * Auto-scope fetching items to magnet parameter.
     *
     * @param MagnetParams $magnet
     */
    protected function handleMagnetFilter(MagnetParams $magnet)
    {
        $magnetFilters = array_build($magnet->toArray(), function ($key) {
            return [$key, [
                'type' => 'text',
                'label' => $key,
            ]];
        });

        $magnetFilters = new Administrator\Filter(app('request'), $magnetFilters, []);

        $this->assembler()->filters($magnetFilters->filters());
    }

    /**
     * Extend query with Order By Statement.
     */
    protected function handleSortable()
    {
        $sortable = app('scaffold.sortable');
        $element = $sortable->element();
        $direction = $sortable->direction();

        if ($element && $direction) {
            if (is_string($element)) {
                $this->assembler()->sort($element, $direction);
            }
        }
    }

    protected function perPage()
    {
        return method_exists($this->module, 'perPage')
            ? $this->module->perPage()
            : 20;
    }

    /**
     * Find a record by id or fail.
     *
     * @param       $key
     * @param array $columns
     *
     * @return mixed
     */
    public function find($key, $columns = ['*'])
    {
        $this->model = $this->model->newQueryWithoutScopes()->findOrFail($key, $columns);

        return $this->model;
    }
}
