<?php

namespace Terranet\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Terranet\Administrator\Contracts\Filter as FilterContract;
use Terranet\Administrator\Contracts\Form\Element;
use Terranet\Administrator\Traits\CallableTrait;

class Filter implements FilterContract
{
    use CallableTrait;

    /**
     * Types class map.
     *
     * @var array
     */
    protected $typesMap = [
        'text' => 'Filters\Element\Text',
        'number' => 'Filters\Element\Number',
        'select' => 'Filters\Element\Select',
        'datalist' => 'Filters\Element\Datalist',
        'date' => 'Filters\Element\Date',
        'daterange' => 'Filters\Element\Daterange',
    ];

    /**
     * Filters collection.
     *
     * @var Collection|null
     */
    protected $filters;

    /**
     * Scopes collection.
     *
     * @var
     */
    protected $scopes;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     * @param array $filters
     * @param array $scopes
     */
    public function __construct(Request $request, array $filters = [], array $scopes = [])
    {
        $this->request = $request;

        $this->setFilters($filters);
        $this->setScopes($scopes);
    }

    public function setFilters(array $filters = [])
    {
        $this->resetFilters();

        foreach ($filters as $name => $options) {
            $type = $this->validateType($options);

            $filterClass = $this->getFilterClass($type);

            $this->createFilterElement(
                (new $filterClass($name))->initFromArray($options)
            );
        }
    }

    protected function resetFilters()
    {
        $this->filters = Collection::make([]);
    }

    /**
     * @param $options
     *
     * @return string
     *
     * @throws Exception
     *
     * @internal param $type
     */
    protected function validateType($options)
    {
        $type = isset($options['type']) ? $options['type'] : $this->getDefaultType();

        if (!array_key_exists($type, $this->typesMap)) {
            throw new Exception(sprintf('Invalid filter type provided: "%s"', $type));
        }

        return $type;
    }

    /**
     * @return string
     *
     * @internal param $type
     */
    protected function getDefaultType()
    {
        return 'text';
    }

    /**
     * @param $type
     *
     * @return string
     *
     * @internal param $options
     */
    protected function getFilterClass($type)
    {
        $filterClass = __NAMESPACE__ . '\\' . $this->typesMap[$type];

        return $filterClass;
    }

    protected function createFilterElement(Element $element)
    {
        if ($this->request->has($element->getName())) {
            $element->setValue(
                $this->request->get($element->getName())
            );
        }

        $this->filters->push($element);
    }

    /**
     * Set scopes.
     *
     * @param array $scopes
     *
     * @return $this
     */
    public function setScopes(array $scopes = [])
    {
        if (!empty($scopes)) {
            $tmp[str_slug('all', '_')] = [
                'name' => 'All',
                'callback' => null,
            ];

            $scopes = $tmp + $scopes;
        }

        $this->scopes = Collection::make($scopes);

        return $this;
    }

    /**
     * Get all filters.
     *
     * @return Collection|null
     */
    public function filters()
    {
        return $this->filters;
    }

    /**
     * Get scopes.
     *
     * @return mixed
     */
    public function scopes()
    {
        return $this->scopes;
    }

    /**
     * Get current scope.
     *
     * @return mixed
     */
    public function scope()
    {
        return $this->request->get('scoped_to', null);
    }

    /**
     * Build an url to desired scope.
     *
     * @param null $scope
     *
     * @return string
     */
    public function makeScopedUrl($scope = null)
    {
        return \admin\helpers\qsRoute(null, [
            'scoped_to' => $scope,
        ]);
    }

    /**
     * Check if filter has element with name.
     *
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        foreach ($this->filters() as $filter) {
            if ($filter->getName() == $name) {
                return true;
            }
        }

        return false;
    }
}
