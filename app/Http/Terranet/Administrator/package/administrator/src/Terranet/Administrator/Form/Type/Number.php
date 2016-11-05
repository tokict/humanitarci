<?php

namespace Terranet\Administrator\Form\Type;

use Form;

class Number extends Text
{
    /**
     * The specific defaults for subclasses to override.
     *
     * @var array
     */
    protected $attributes = [
        'min' => null,
        'max' => null,
        'class' => 'form-control',
        'style' => 'width: 150px;',
    ];

    /**
     * The specific rules for subclasses to override.
     *
     * @var array
     */
    protected $rules = [
        'min' => 'numeric',
        'max' => 'numeric',
    ];

    public function renderInput()
    {
        return Form::input('number', $this->name, $this->value, $this->attributes);
    }
}
