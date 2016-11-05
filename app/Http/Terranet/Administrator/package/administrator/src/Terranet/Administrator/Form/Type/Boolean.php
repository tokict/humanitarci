<?php

namespace Terranet\Administrator\Form\Type;

use Form;
use Terranet\Administrator\Form\Element;

class Boolean extends Element
{
    public $value = null;

    protected $attributes = [];

    public function renderInput()
    {
        return
            Form::hidden($this->name, 0, ['id' => Form::getIdAttribute($this->name, $this->attributes) . '_hidden']) .
            Form::checkbox($this->name, 1, $this->value, $this->attributes);
    }
}
