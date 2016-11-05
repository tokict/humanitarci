<?php

namespace Terranet\Administrator\Form\Type;

class Tel extends Text
{
    /**
     * The specific defaults for subclasses to override.
     *
     * @var array
     */
    protected $attributes = [
        'style' => 'width: 150px;',
        'class' => 'form-control',
    ];

    /**
     * The specific rules for subclasses to override.
     *
     * @var array
     */
    protected $rules = [];

    public function renderInput()
    {
        return \Form::input('tel', $this->name, $this->value, $this->attributes);
    }
}
