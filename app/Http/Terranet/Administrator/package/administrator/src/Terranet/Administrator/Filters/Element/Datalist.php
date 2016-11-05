<?php

namespace Terranet\Administrator\Filters\Element;

use Form;
use Terranet\Administrator\Contracts\Form\Queryable;
use Terranet\Administrator\Form\Element;
use Terranet\Administrator\Traits\CallableTrait;
use Terranet\Administrator\Traits\Form\ExecutesQuery;

class Datalist extends Element implements Queryable
{
    use CallableTrait, ExecutesQuery;

    protected $multiple = false;

    protected $options = [];

    public function renderInput()
    {
        $name = $this->getName();

        $id = 'scaffold_' . str_slug($name);
        $attributes = array_merge($this->attributes, [
            'list' => $id,
        ]);

        $out[] = '<!-- Scaffold: ' . $this->getName() . ' -->';
        $out[] = Form::label($this->getName(), $this->getLabel());
        $out[] = Form::text($name, $this->getValue(), $attributes);

        $out[] = '<datalist id="' . $id . '">';

        foreach ($this->getOptions() as $key => $option) {
            if (is_numeric($key)) {
                $out[] = '<option value="' . $option . '"></option>';
            } else {
                $out[] = '<option value="' . $key . '">' . $option . '</option>';
            }
        }

        $out[] = '</datalist>';

        return join(PHP_EOL, $out);
    }

    public function getOptions()
    {
        $options = $this->options;

        if (empty($options)) {
            return [];
        }

        if (is_callable($options)) {
            return $this->callback($options);
        }

        return (array) $options;
    }
}
