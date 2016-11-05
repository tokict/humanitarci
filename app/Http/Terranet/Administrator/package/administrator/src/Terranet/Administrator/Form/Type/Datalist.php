<?php

namespace Terranet\Administrator\Form\Type;

use Form;
use Terranet\Administrator\Form\Element;

class Datalist extends Select
{
    protected $rules = [
        //
    ];

    public function renderInput()
    {
        $name = $this->name;

        $id = 'scaffold_' . str_slug($name);
        $attributes = array_merge($this->attributes, [
            'list' => $id,
        ]);

        $out[] = Form::text($name, $this->getValue(), $attributes);

        $out[] = '<datalist id="' . $id . '">';
        foreach ($this->options as $key => $option) {
            if (is_numeric($key)) {
                $out[] = '<option value="' . $option . '"></option>';
            } else {
                $out[] = '<option value="' . $key . '">' . $option . '</option>';
            }
        }
        $out[] = '</datalist>';

        return join(PHP_EOL, $out);
    }
}
