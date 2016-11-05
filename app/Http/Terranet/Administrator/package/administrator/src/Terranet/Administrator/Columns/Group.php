<?php

namespace Terranet\Administrator\Columns;

use Coduo\PHPHumanizer\StringHumanizer;
use Illuminate\Database\Eloquent\Collection;

class Group extends ColumnAbstract
{
    /**
     * List of elements included in group.
     *
     * @var Collection
     */
    protected $elements = [];

    public function __construct($name, $title, array $elements)
    {
        $this->name = $name;

        if (empty($title)) {
            $title = $name;
        }
        $this->title = StringHumanizer::humanize($title);

        $this->setElements($elements);
    }

    /**
     * @param array $elements
     *
     * @return $this
     */
    public function setElements($elements)
    {
        $this->elements = Collection::make([]);

        foreach ($elements as $column => $options) {
            $element = new Column($column, $options);

            $this->elements->push($element);
        }

        return $this;
    }

    /**
     * Retrieve list of grouped elements.
     *
     * @return array
     */
    public function elements()
    {
        return $this->elements;
    }
}
