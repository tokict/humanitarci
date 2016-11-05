<?php

namespace Terranet\Administrator\Form\Type;

use Form;
use Terranet\Administrator\Form\Element;

class Select extends Element
{
    /**
     * List of options.
     *
     * @var array
     */
    protected $options = [];

    protected $attributes = [
        'class' => 'form-control',
        'style' => 'width: 300px;',
    ];

    protected $rules = [
        'options' => 'required',
    ];

    public function setOptions($options)
    {
        /*
         * Multiple Options can be provided using different styles
         * 1. closure function() { return ['list', 'of', 'values']; }
         * 2. callable [$object, "method"]
         * 3. string "Class@Method"
         */
        if ($callable = $this->callableOptions($options)) {
            $options = call_user_func($callable);
        }

        $this->options = $options;

        return $this;
    }

    /**
     * Parse options and try to resolve values.
     *
     * @param $callable
     *
     * @return mixed bool|array|callable
     */
    protected function callableOptions($callable)
    {
        // resolve closure
        if (is_callable($callable)) {
            return $callable;
        }

        // resolve callable "Class@method" style
        if (is_string($callable) && list($class, $method) = explode('@', $callable)) {
            return [app()->make($class), $method];
        }

        // resolve callable [$object, "method"]
        if (count($callable) == 2 && array_key_exists(0, $callable) && array_key_exists(1, $callable)) {
            if (is_object($class = $callable[0]) && is_string($method = $callable[1]) && method_exists($class, $method)) {
                return [$class, $method];
            }
        }

        return false;
    }

    public function renderInput()
    {
        $name = $this->name;

        if (isset($this->attributes['multiple']) && $this->attributes['multiple']) {
            $this->attributes['id'] = Form::getIdAttribute($name, $this->attributes);
            $name = $name . '[]';
        }

        return Form::select($name, $this->options, $this->value, $this->attributes);
    }
}
