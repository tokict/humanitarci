<?php

namespace Terranet\Administrator\Form\Type;

use Terranet\Administrator\Form\Element;

class Key extends Element
{
    protected $value = null;

    public function renderInput()
    {
        return $this->getValue();
    }
}
