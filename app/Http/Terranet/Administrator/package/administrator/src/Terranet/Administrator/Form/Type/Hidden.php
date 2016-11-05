<?php

namespace Terranet\Administrator\Form\Type;

use Form;
use Terranet\Administrator\Contracts\Form\HiddenElement;
use Terranet\Administrator\Form\Element;

class Hidden extends Element implements HiddenElement
{
    /**
     * The specific defaults for subclasses to override.
     *
     * @var array
     */
    protected $attributes = [];

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
        return Form::hidden($this->name, $this->value, $this->attributes);
    }
}
