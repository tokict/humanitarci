<?php

namespace Terranet\Administrator\Contracts\Form;

interface Element
{
    /**
     * Set the elements value.
     *
     * @param $value
     *
     * @return $this
     */
    public function setValue($value = null);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getType();

    /**
     * Set element HTML Attributes.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function setAttributes(array $attributes = null);

    /**
     * Create Element from an array of options.
     * Options depends of Element type.
     *
     * @param array $options
     *
     * @return mixed
     */
    public function initFromArray(array $options = null);
}
