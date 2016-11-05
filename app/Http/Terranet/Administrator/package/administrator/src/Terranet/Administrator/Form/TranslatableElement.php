<?php

namespace Terranet\Administrator\Form;

use Terranet\Administrator\Contracts\Form\FormElement;
use Terranet\Administrator\Contracts\Form\Validable;
use Terranet\Administrator\Traits\Form\FormControl;
use Terranet\Administrator\Traits\Form\ValidatesFormElement;

class TranslatableElement implements FormElement, Validable
{
    use ValidatesFormElement, FormControl;

    /**
     * @var Element
     */
    protected $element;

    public function __construct(Element $element)
    {
        $this->element = $element;
    }

    /**
     * @return mixed
     */
    public function html()
    {
        $name = $this->element->getName();

        /**
         * to be able using translations we have to get element's Eloquent model.
         *
         * @var \Terranet\Translatable\Translatable;
         */
        $repository = app('scaffold.model') ?: app('scaffold.module')->model();

        $cycle = 0;
        $current = \localizer\locale();
        $inputs = array_build(
            \localizer\locales(),
            function ($key, $locale) use ($repository, $name, $current, &$cycle) {
                // clone original element for modification
                $element = clone $this->element;

                // set translated value
                if ($repository->hasTranslation($locale->id())) {
                    $element->setValue($repository->translate($locale->id())->$name);
                }

                // set element belongs to locale
                $element->setName("translatable[{$locale->id()}][{$name}]");

                $input = $element->html();
                $input = '<div class="translatable '.
                            ($locale->id() == $current->id()
                                ? ''
                                : 'hidden').'" data-locale="'.($locale->id()).'">'.
                            $input.
                         '</div>';

                return [$cycle++, $input];
            }
        );

        $inputs = implode('', $inputs);

        $html = <<<HTML
<div class="translatable-block">
	<div class="translatable-items pull-left" style="margin-right: 20px;">
		{$inputs}
	</div>
	{$this->localeSwitcher()}
</div>
HTML;

        return $html;
    }

    private function localeSwitcher()
    {
        $current = \localizer\locale();
        $buttons = array_build(\localizer\locales(), function ($key, $locale) use ($current) {
            $button = '<button type="button" class="btn btn-default btn-sm '.
                        ($locale->id() == $current->id() ? 'active' : '').'" data-locale="'.$locale->id().'">'.
                        $locale->iso6391().
                    '</button>';

            return [$key, $button];
        });
        $buttons = implode('', $buttons);

        return <<<SWITCHER
<div class="box-tools pull-left locale-switcher" data-toggle="tooltip" data-original-title="Switch locale">
	<div class="btn-group" data-toggle="btn-toggle">
		{$buttons}
	</div>
</div>
SWITCHER;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->element->getLabel();
    }

    public function getName()
    {
        return $this->element->getName();
    }

    public function getDescription()
    {
        return $this->element->getDescription();
    }

    public function getType()
    {
        return $this->element->getType();
    }
}
