<?php

namespace Terranet\Administrator\Columns;

use Terranet\Administrator\Columns\Contracts\Column;

class ColumnAbstract implements Column
{
    /**
     * Column name.
     *
     * @var
     */
    protected $name;

    /**
     * Column title.
     *
     * @var
     */
    protected $title;

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Detect group of columns.
     *
     * @return mixed
     */
    public function isGroup()
    {
        return $this instanceof Group;
    }
}
