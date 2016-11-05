<?php

namespace Terranet\Administrator\Columns;

use Coduo\PHPHumanizer\StringHumanizer;
use Terranet\Administrator\Columns\Contracts\Presentable;
use Terranet\Administrator\Exception;
use Terranet\Administrator\Traits\CallableTrait;
use Terranet\Administrator\Traits\LoopsOverRelations;

class Column extends ColumnAbstract implements Presentable
{
    use LoopsOverRelations, CallableTrait;

    protected $outputCallback;

    protected $standalone = false;

    protected $after;

    /**
     * List of relations queued to run for value fetching.
     *
     * @var array
     */
    protected $relations = [];

    public function __construct($column, $options = null)
    {
        if ($this->simpleDeclaration($column, $options)) {
            list($name, $title, $standalone, $output, $after) = $this->initFromString($options);
        } elseif ($this->detailedDeclaration($column, $options)) {
            list($name, $title, $standalone, $output, $after) = $this->initFromArray($column, $options);
        } else {
            throw new Exception('Invalid column declaration');
        }

        $this->setName($name);

        $this->setTitle($title, $name);

        $this->standalone = (bool) $standalone;

        $this->outputCallback = $output;

        /*
         *  implement ordering
         */
        $this->setAfter($after);
    }

    /**
     * Column declared using simple way.
     *
     * @example: id, username, etc...
     *
     * @param $column
     * @param $options
     *
     * @return bool
     */
    private function simpleDeclaration($column, $options)
    {
        return is_numeric($column) && is_string($options);
    }

    /**
     * Column declared using advanced style.
     *
     * @example 'email' => ['output' => '<a href="mailto:(:email)">(:email)</a>']
     *
     * @param $column
     * @param $options
     *
     * @return bool
     */
    private function detailedDeclaration($column, $options)
    {
        return is_string($column) && is_array($options);
    }

    /**
     * @param $name
     */
    protected function setName($name)
    {
        if ($this->isRelation($name)) {
            $relations = explode('.', $name);

            $name = array_pop($relations);

            $this->relations = $relations;
        }

        $this->name = $name;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    protected function isRelation($name)
    {
        return false !== stripos($name, '.');
    }

    /**
     * @param $title
     * @param $name
     */
    protected function setTitle($title, $name)
    {
        if (empty($title)) {
            $title = $name;
        }

        if ($this->isRelation($title)) {
            $parts = explode('.', $title);
            $title = array_pop($parts);
        }

        $title = StringHumanizer::humanize($title);

        $this->title = $title;
    }

    /**
     * @param mixed $after
     */
    public function setAfter($after)
    {
        $this->after = $after;
    }

    /**
     * Get formatted value of a column.
     *
     * @param $eloquent
     *
     * @return mixed
     */
    public function format($eloquent)
    {
        if (!$this->outputCallback) {
            return $this->value($eloquent);
        }

        if (is_callable($this->outputCallback)) {
            return $this->callback($this->outputCallback, $eloquent);
        }

        return preg_replace_callback('~\(\:([a-z0-9\_]+)\)~si', function ($matches) use ($eloquent) {
            $field = $matches[1];

            return \admin\helpers\eloquent_attribute($eloquent, $field);
        }, $this->outputCallback);
    }

    /**
     * Get columns raw value.
     *
     * @param $eloquent
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function value($eloquent)
    {
        $name = $this->name();

        if ($this->relations) {
            return $this->fetchRelationValue($eloquent, $name, $this->relations, true);
        }

        return \admin\helpers\eloquent_attribute($eloquent, $name);
    }

    /**
     * Check if column is standalone.
     *
     * @return bool
     */
    public function standalone()
    {
        return $this->standalone;
    }

    /**
     * @param $options
     *
     * @return array
     */
    public function initFromString($options)
    {
        $name = $options;
        $title = $name;
        $standalone = false;
        $output = $after = null;

        return [$name, $title, $standalone, $output, $after];
    }

    /**
     * @param $column
     * @param $options
     *
     * @return array
     */
    public function initFromArray($column, $options)
    {
        $name = $column;
        $defaultValues = ['title' => null, 'standalone' => false, 'output' => null, 'after' => null];

        foreach ($defaultValues as $variable => $value) {
            $$variable = isset($options[$variable]) ? $options[$variable] : $value;
        }

        return [$name, $title, $standalone, $output, $after];
    }
}
