<?php

namespace Terranet\Administrator\Form\Type;

use Form;

class Markdown extends Textarea
{
    public function renderInput()
    {
        $attributes = $this->attributes + ['data-editor' => 'markdown'];

        return Form::textarea($this->name, $this->value, $attributes);
    }
}
