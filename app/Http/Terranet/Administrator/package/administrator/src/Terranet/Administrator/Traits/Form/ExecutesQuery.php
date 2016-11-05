<?php

namespace Terranet\Administrator\Traits\Form;

trait ExecutesQuery
{
    /**
     * Elements query
     *
     * @var
     */
    protected $query;

    /**
     * Check if Filter element has a query
     *
     * @return bool
     */
    public function hasQuery()
    {
        return isset($this->query) && is_callable($this->query);
    }

    /**
     * Execute filter element's query
     *
     * @return Builder|mixed
     */
    public function execQuery()
    {
        return call_user_func_array($this->query, func_get_args());
    }
}
