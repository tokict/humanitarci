<?php

namespace Terranet\Administrator\Columns\Contracts;

interface Column
{
    /**
     * Get column name.
     *
     * @return mixed
     */
    public function name();

    /**
     * Get column title.
     *
     * @return mixed
     */
    public function title();
}
