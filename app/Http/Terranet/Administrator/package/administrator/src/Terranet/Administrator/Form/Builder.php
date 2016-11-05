<?php

namespace Terranet\Administrator\Form;

use Illuminate\Support\Collection;
use Terranet\Administrator\Exception;
use Terranet\Administrator\Exceptions\UnknownFieldTypeException;

class Builder
{
    /**
     * Fields that should be translated.
     *
     * @var array
     */
    protected $translatable = [];

    /**
     * @var array
     */
    private $fields = null;

    private $cleanFields = [];

    /**
     * The valid field types and their associated classes.
     *
     * @var array
     */
    private $fieldTypes = [
        'key' => 'Terranet\\Administrator\\Form\\Type\\Key',
        'text' => 'Terranet\\Administrator\\Form\\Type\\Text',
        'hidden' => 'Terranet\\Administrator\\Form\\Type\\Hidden',
        'email' => 'Terranet\\Administrator\\Form\\Type\\Email',
        'select' => 'Terranet\\Administrator\\Form\\Type\\Select',
        'datalist' => 'Terranet\\Administrator\\Form\\Type\\Datalist',
        'textarea' => 'Terranet\\Administrator\\Form\\Type\\Textarea',
        'ckeditor' => 'Terranet\\Administrator\\Form\\Type\\Ckeditor',
        'tinymce' => 'Terranet\\Administrator\\Form\\Type\\Tinymce',
        'markdown' => 'Terranet\\Administrator\\Form\\Type\\Markdown',
        'password' => 'Terranet\\Administrator\\Form\\Type\\Password',
        'date' => 'Terranet\\Administrator\\Form\\Type\\Date',
        'daterange' => 'Terranet\\Administrator\\Form\\Type\\Daterange',
        'time' => 'Terranet\\Administrator\\Form\\Type\\Time',
        'datetime' => 'Terranet\\Administrator\\Form\\Type\\Datetime',
        'number' => 'Terranet\\Administrator\\Form\\Type\\Number',
        'tel' => 'Terranet\\Administrator\\Form\\Type\\Tel',
        'boolean' => 'Terranet\\Administrator\\Form\\Type\\Boolean',
        'image' => 'Terranet\\Administrator\\Form\\Type\\Image',
        'file' => 'Terranet\\Administrator\\Form\\Type\\File',
        'color' => 'Terranet\\Administrator\\Form\\Type\\Color',
    ];

    public function __construct(array $fields = [])
    {
        $this->cleanFields = $fields;
    }

    public function getEditors()
    {
        if (! $this->fields) {
            $this->getFields();
        }

        $editors = [];

        foreach ($this->fields as $field) {
            if ($this->isOfType($field, $editors, 'tinymce')) {
                $editors[] = 'tinymce';
            }

            if ($this->isOfType($field, $editors, 'ckeditor')) {
                $editors[] = 'ckeditor';
            }
        }

        return $editors;
    }

    public function getFields()
    {
        if (null === $this->fields) {
            $fields = [];

            foreach ($this->cleanFields as $name => $options) {
                $element = $this->stringDeclaration($name, $options)
                    ? $this->createElement('text', [], $options)
                    : $this->initFromArray($name, $options);

                $fields[] = $element;
            }

            $this->fields = Collection::make($fields);
        }

        return $this->fields;
    }

    /**
     * @param $name
     * @param $options
     *
     * @return bool
     */
    protected function stringDeclaration($name, $options)
    {
        return is_numeric($name) && is_string($options);
    }

    /**
     * @param $type
     * @param $options
     * @param $name
     *
     * @return mixed
     *
     * @throws UnknownFieldTypeException
     */
    private function createElement($type, $options, $name)
    {
        $className = $this->fieldTypes[$type];

        if (! $className) {
            throw new UnknownFieldTypeException(sprintf("Unknown field of type '%s'", $options['type']));
        }

        $element = (new $className($name))->initFromArray($options);

        return $element;
    }

    /**
     * @param $name
     * @param $options
     *
     * @return array
     *
     * @throws Exception
     * @throws UnknownFieldTypeException
     */
    protected function initFromArray($name, $options)
    {
        if (! (is_string($name) && is_array($options))) {
            throw new Exception(sprintf('Can not initialize element [%s]', $name));
        }

        $type = $options['type'];
        $element = $this->createElement($type, $options, $name);

        if (isset($options['translatable']) && (bool) $options['translatable']) {
            return new TranslatableElement($element);
        }

        return $element;
    }

    /**
     * @param $field
     * @param $editors
     * @param $type
     *
     * @return bool
     */
    protected function isOfType($field, $editors, $type)
    {
        return $field->getType() == $type && ! in_array($type, $editors);
    }
}
