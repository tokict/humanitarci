<?php

namespace Terranet\Administrator\Contracts\Form;

interface FormElement
{
    public function setDescription($description);

    public function getDescription();

    /**
     * @param null $label
     */
    public function setLabel($label = null);

    /**
     * @return mixed
     */
    public function getLabel();

    /**
     * @return mixed
     */
    public function html();
}
