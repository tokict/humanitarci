<?php

namespace Terranet\Administrator\Filters\Element;

use Form;
use Terranet\Administrator\Contracts\Form\Queryable;
use Terranet\Administrator\Form\Element;
use Terranet\Administrator\Traits\Form\ExecutesQuery;

class Number extends Element implements Queryable
{
    use ExecutesQuery;

    public function renderInput()
    {
        return '<!-- Scaffold: '.$this->getName().' -->'.
                Form::label($this->getName(), $this->getLabel()).
                Form::text($this->getName(), $this->getValue(), $this->attributes);
    }
}
