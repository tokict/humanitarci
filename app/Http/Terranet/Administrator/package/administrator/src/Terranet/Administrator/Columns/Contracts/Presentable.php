<?php

namespace Terranet\Administrator\Columns\Contracts;

interface Presentable
{
    /**
     * Get columns raw value.
     *
     * @param $eloquent
     *
     * @return mixed
     */
    public function value($eloquent);

    /**
     * Get column formatted value.
     *
     * @param $eloquent
     *
     * @return mixed
     */
    public function format($eloquent);
}
