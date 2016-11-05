<?php

namespace Terranet\Administrator\Form\Type;

class Image extends File
{
    /**
     * Show specific image style
     *
     * @var null
     */
    protected $style = null;

    /**
     * Link to specific image style.
     *
     * @var null
     */
    protected $zoomToStyle = null;

    /**
     * @return array|string
     */
    protected function listFiles()
    {
        $files = [];

        foreach ($styles = $this->value()->getConfig()->styles as $style) {
            if (($this->style && $this->style !== $style->name) || $this->isOriginal($style) && $this->hasMany($styles)) {
                continue;
            }

            $img = '<img src="' . $this->value()->url($style->name) . '" />';
            if ($this->zoomToStyle) {
                $img = '<a href="' .$this->value()->url($this->zoomToStyle).'" class="fancybox">' . $img . '</a>';
            }

            $files[] = $img;
        }

        $files = implode('&nbsp;', $files);

        return $files;
    }

    private function isOriginal($style)
    {
        return 'original' == $style->name;
    }

    /**
     * @param $styles
     *
     * @return bool
     */
    protected function hasMany($styles)
    {
        return count($styles) > 1;
    }
}
