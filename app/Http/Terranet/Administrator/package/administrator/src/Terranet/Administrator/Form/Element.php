<?php

namespace Terranet\Administrator\Form;

use Terranet\Administrator\Contracts\Form\Element as ElementInterface;
use Terranet\Administrator\Contracts\Form\FormElement;
use Terranet\Administrator\Contracts\Form\Relationship;
use Terranet\Administrator\Contracts\Form\Validable;
use Terranet\Administrator\Traits\Form\FormControl;
use Terranet\Administrator\Traits\Form\HasRelation;
use Terranet\Administrator\Traits\Form\ValidatesFormElement;

abstract class Element implements FormElement, ElementInterface, Validable, Relationship
{
    use FormControl, ValidatesFormElement, HasRelation;

    protected $translatable = false;

    public function __construct($name)
    {
        // by default set label equal to name
        $this->setLabel($this->setName($name));
    }

    public function initFromArray(array $options = null)
    {
        $this->attributes = array_merge($this->attributes, array_except($options, 'type'));

        $this->validateAttributes();

        $this->decoupleOptionsFromAttributes();

        $this->setDefaultValue();

        return $this;
    }

    protected function setDefaultValue()
    {
        /**
         * Set default value from Eloquent model.
         */
        if (($element = $this->getRepository()) && $element->exists) {
            if ($value = $element->getAttribute($this->name)) {
                return $this->setValue($value);
            }
        }

        /**
         * Try to extract value from Closure provided by form configuration
         * Note: checking for function_exists is set to ensure that \Closure is provided
         * and protect calling functions when provided value is something like 'rand' which is also is_callable
         */
        if (is_callable($closure = $this->getValue())) {
            if (! (is_string($closure) && function_exists($closure))) {
                $value = call_user_func($closure, $this->getRepository());
                return $this->setValue($value);
            }
        }

        /**
         * If relation detected => try to extract value from relation or magnet link
         */
        if ($this->hasRelation() && ($repository = $this->getRepository())) {
            if (!$value = $this->extractValueFromEloquentRelation($repository)) {
                if ($magnet = $this->isMagnetParameter()) {
                    $value = $magnet[$this->getName()];
                }
            }

            return $this->setValue($value);
        }

        /**
         * If column configured as a magnet link, so try to extract value form Request
         */
        if ($magnet = $this->isMagnetParameter()) {
            return $this->setValue($magnet[$this->getName()]);
        }

        return null;
    }

    protected function getRepository()
    {
        return app('scaffold.model') ?: app('scaffold.module')->model();
    }

    protected function isMagnetParameter()
    {
        return array_key_exists(
            $this->getName(),
            $magnet = app('scaffold.magnet')->toArray()
        ) ? $magnet : false;
    }

    final public function html()
    {
        $this->setDefaultValue();

        return $this->renderInput() . $this->renderErrors();
    }

    /**
     * Each subclass should have this method realized.
     *
     * @return mixed
     */
    abstract public function renderInput();
}
