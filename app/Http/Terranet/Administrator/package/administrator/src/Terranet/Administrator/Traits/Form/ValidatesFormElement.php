<?php

namespace Terranet\Administrator\Traits\Form;

use Terranet\Administrator\Exceptions\WrongFieldAttributeException;
use Validator;

trait ValidatesFormElement
{
    protected $errors = [];

    protected $rules = [];

    /**
     * @param array $rules
     *
     * @return $this
     */
    public function setRules(array $rules = [])
    {
        $this->rules = $rules;

        return $this;
    }

    protected function validateAttributes()
    {
        $validator = Validator::make($this->attributes, $this->rules);

        if ($validator->fails()) {
            $message = sprintf(
                "Field \"{$this->name}\" fails with messages: %s",
                join("; ", $validator->getMessageBag()->all())
            );
            throw new WrongFieldAttributeException($message);
        }
    }

    /**
     * Check if
     *
     * @return bool
     */
    public function hasErrors()
    {
        return ! empty($this->errors);
    }

    protected function renderErrors()
    {
        if (empty($this->errors)) {
            return "";
        }

        return "<ul class=\"errors\"><li>" . join("</li><li>", $this->errors) . "</li></ul>";
    }
}
