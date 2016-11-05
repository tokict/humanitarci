<?php

namespace Terranet\Administrator\Form\Type;

use Form;

class Ckeditor extends Textarea
{
    public function renderInput()
    {
        $attributes = $this->attributes + ['data-editor' => 'ckeditor'];

        return Form::textarea($this->name, $this->value, $attributes);
    }
}
