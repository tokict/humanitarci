<?php

namespace Terranet\Administrator\Filters\Element;

use Form;
use Terranet\Administrator\Contracts\Form\Queryable;
use Terranet\Administrator\Form\Element;
use Terranet\Administrator\Traits\Form\ExecutesQuery;

class Date extends Element implements Queryable
{
    use ExecutesQuery;

    public function renderInput()
    {
        return '<!-- Scaffold: '.$this->getName().' -->'.
                Form::label($this->getName(), $this->getLabel()).
                '<div class="input-group">'.
                '   <div class="input-group-addon"><i class="fa fa-calendar"></i></div>'.
                    Form::text(
                        $this->getName(),
                        $this->getValue(),
                        $this->attributes + ['data-filter-type' => $this->getClassName()]
                    ).
                '</div>';
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        $parts = explode('\\', get_class($this));

        return strtolower(array_pop($parts));
    }
}
