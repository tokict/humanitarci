<?php

namespace Terranet\Administrator\Contracts;

interface Filter
{
    /**
     * Set filters.
     *
     * @param array $filters
     *
     * @return mixed
     */
    public function setFilters(array $filters = []);

    /**
     * Set scopes.
     *
     * @param array $scopes
     *
     * @return mixed
     */
    public function setScopes(array $scopes = []);

    /**
     * Get Filters.
     *
     * @return mixed
     */
    public function filters();

    /**
     * Get scopes.
     *
     * @return mixed
     */
    public function scopes();
}
