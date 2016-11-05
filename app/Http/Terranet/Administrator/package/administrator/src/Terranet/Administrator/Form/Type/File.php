<?php

namespace Terranet\Administrator\Form\Type;

use Codesleeve\Stapler\Attachment;
use Form;
use Terranet\Administrator\Form\Element;

class File extends Element
{
    protected $relation;

    /**
     * Require file deletion before new upload
     *
     * @var bool
     */
    protected $forceDelete = true;

    /**
     * @var Attachment
     */
    protected $value;

    public function renderInput()
    {
        $value = $this->value();

        if ($value && !($value instanceof Attachment)) {
            throw new \Exception("Please attach an Attachment to the {$this->name} field");
        }

        return $this->getOutput() . $this->getInput();
    }

    /**
     * @return string
     */
    protected function getOutput()
    {
        $output = null;

        if ($this->hasFile()) {
            $files = $this->listFiles();
            $output = $files
                . ($this->forceDelete ? $this->detachLink() : '');
        }

        return $output;
    }

    /**
     * @return mixed
     */
    protected function getInput()
    {
        if (!$this->hasFile() || !$this->forceDelete) {
            return Form::file($this->name, $this->attributes);
        }

        return null;
    }

    /**
     * @return array|string
     */
    protected function listFiles()
    {
        $files = [];

        foreach ($this->value()->getConfig()->styles as $style) {
            $files[] = link_to($this->value()->url($style->name), $this->value()->originalFilename());
        }

        $files = implode('&nbsp;', $files);

        return $files;
    }

    /**
     * @return bool
     */
    protected function hasFile()
    {
        return is_a($this->value(), Attachment::class) && $this->value()->originalFilename();
    }

    /**
     * @return string
     *
     * @throws \Terranet\Administrator\Exception
     */
    protected function detachLink()
    {
        return ''
        . '<div class="row box-body">'
        . link_to_route('scaffold.delete_attachment', 'Delete', [
            'module' => app('scaffold.module'),
            'attachment' => $this->getName(),
            'id' => $this->getRepository(),
        ], [
            'onclick' => 'return confirm(\'Are you sure?\');',
            'class' => 'btn btn-danger',
            'style' => 'padding: 2px 8px;',
        ])
        . '</div>';
    }

    /**
     * @return mixed
     */
    protected function value()
    {
        $name = $this->getName();

        return $this->getRepository()->$name;
    }
}
