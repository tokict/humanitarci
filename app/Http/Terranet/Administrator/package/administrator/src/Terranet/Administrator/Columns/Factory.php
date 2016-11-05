<?php

namespace Terranet\Administrator\Columns;

use Illuminate\Database\Eloquent\Collection;

class Factory
{
    protected $cleanColumns = [];

    protected $columns = null;

    public function __construct(array $columns)
    {
        $this->cleanColumns = $columns;
    }

    /**
     * Get list of columns.
     *
     * @param bool $force
     *
     * @return array|null
     */
    public function getColumns($force = false)
    {
        if (null === $this->columns || (bool) $force) {
            $this->columns = new Collection();

            foreach ($this->cleanColumns as $column => $options) {
                $item = $this->isGroup($options)
                    ? $this->initGroup($column, $options)
                    : $this->initColumn($column, $options);

                $this->columns->push($item);
            }
        }

        return $this->columns;
    }

    /**
     * @param $options
     *
     * @return bool
     */
    private function isGroup($options)
    {
        return is_array($options) && array_key_exists('elements', $options);
    }

    /**
     * @param $column
     * @param $options
     *
     * @return Group
     */
    protected function initGroup($column, $options)
    {
        $title = isset($options['title']) ? $options['title'] : $column;

        return new Group($column, $title, $options['elements']);
    }

    /**
     * @param $column
     * @param $options
     *
     * @return Column
     */
    protected function initColumn($column, $options)
    {
        return new Column($column, $options);
    }
}
