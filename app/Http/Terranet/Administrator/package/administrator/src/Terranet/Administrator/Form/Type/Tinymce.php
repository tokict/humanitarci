<?php

namespace Terranet\Administrator\Form\Type;

use Form;

class Tinymce extends Textarea
{
    public function renderInput()
    {
        $attributes = $this->attributes + ['data-editor' => 'tinymce'];

        return Form::textarea($this->name, $this->value, $attributes);
    }
}
