<?php

namespace Terranet\Administrator\Form\Type;

use Form;

class Email extends Text
{
    public function renderInput()
    {
        return Form::email($this->name, $this->value, $this->attributes);
    }
}
