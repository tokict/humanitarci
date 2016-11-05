<?php

namespace Terranet\Administrator\Traits\Module;

trait HasOptions
{
    /**
     * List of editable options
     *
     * @return array
     */
    public function form()
    {
        return $this->scaffoldForm();
    }

    protected function scaffoldForm()
    {
        return array_build(options_fetch(), function ($key, $option) {
            return [$option->key, ['type' => 'text']];
        });
    }
}
