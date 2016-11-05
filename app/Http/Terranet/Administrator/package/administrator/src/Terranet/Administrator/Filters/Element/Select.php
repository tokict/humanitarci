<?php

namespace Terranet\Administrator\Filters\Element;

use Form;
use Terranet\Administrator\Contracts\Form\Queryable;
use Terranet\Administrator\Form\Element;
use Terranet\Administrator\Traits\CallableTrait;
use Terranet\Administrator\Traits\Form\ExecutesQuery;

class Select extends Element implements Queryable
{
    use CallableTrait, ExecutesQuery;

    protected $multiple = false;

    public function renderInput()
    {
        $name = $this->getName();

        if ($this->multiple) {
            $name = "{$name}[]";
            $this->attributes['multiple'] = 'multiple';
        }

        return '<!-- Scaffold: '.$this->getName().' -->'.
                Form::label($this->getName(), $this->getLabel()).
                Form::select($name, $this->getOptions(), $this->getValue(), $this->attributes);
    }

    public function getOptions()
    {
        $options = $this->options;

        if (empty($options)) {
            return [];
        }

        if (is_callable($options)) {
            return $this->callback($options);
        }

        return (array) $options;
    }
}
