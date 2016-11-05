<?php

namespace Terranet\Administrator\Form\Type;

use Form;
use Terranet\Administrator\Form\Element;

class Text extends Element
{
    /**
     * The specific defaults for subclasses to override.
     *
     * @var array
     */
    protected $attributes = [
        'maxlength' => 100,
        'class' => 'form-control',
        'style' => 'width: 300px;',
    ];

    /**
     * The specific rules for subclasses to override.
     *
     * @var array
     */
    protected $rules = [
        'maxlength' => 'integer|min:0|max:255',
    ];

    public function renderInput()
    {
        return Form::text($this->name, $this->value, $this->attributes);
    }
}
