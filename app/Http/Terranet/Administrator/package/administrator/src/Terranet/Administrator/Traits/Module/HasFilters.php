<?php

namespace Terranet\Administrator\Traits\Module;

use Coduo\PHPHumanizer\StringHumanizer;
use Terranet\Translatable\Translatable;

trait HasFilters
{
    /**
     * Defined filters
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Defined scopes
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * Default list of filters
     *
     * @return mixed
     */
    public function filters()
    {
        return $this->scaffoldFilters();
    }

    protected function scaffoldFilters()
    {
        if (empty($this->filters)) {
            $model = $this->model();
            $schema = app('scaffold.schema');
            $table = $model->getTable();

            $indexes = $schema->indexedColumns($table);
            $columns = $schema->columns($table);

            if ($model instanceof Translatable) {
                $translation = $model->getTranslationModel();
                $indexes = array_merge($indexes, $schema->indexedColumns($translation->getTable()));

                $columns = array_merge(
                    $columns,
                    array_except($schema->columns($translation->getTable()), array_keys($columns))
                );
            }

            foreach ($indexes as $column) {
                $data = $columns[$column];

                switch (class_basename($data->getType())) {
                    case 'StringType':
                        $this->addFilter($column, 'text');
                        break;

                    case 'DateTimeType':
                        $this->addFilter($column, 'daterange');
                        break;

                    case 'BooleanType':
                        $this->addFilter($column, 'select', '', [
                            '' => '--Any--',
                            1 => 'Yes',
                            0 => 'No'
                        ]);
                        break;
                }
            }
        }

        return $this->filters;
    }

    protected function addFilter($name, $type = 'text', $label = '', array $options = [], callable $query = null)
    {
        $this->filters[$name] = [
            'type' => $type,
            'label' => $label ?: ucfirst(str_replace('_', ' ', $name)),
            'options' => $options,
            'query' => $query,
        ];
    }

    /**
     * Default list of scopes
     */
    public function scopes()
    {
        return $this->scaffoldScopes();
    }

    /**
     * Find all public scopes in current model
     *
     * @return array
     */
    protected function scaffoldScopes()
    {
        $this->resetScopes();

        if ($model = $this->model()) {
            $this->fetchModelScopes($model);

            $this->addSoftDeletesScopes($model);
        }

        return $this->scopes;
    }

    /**
     * @return array
     */
    protected function resetScopes()
    {
        return $this->scopes = [];
    }

    /**
     * Parse the model for scopes
     *
     * @param $model
     */
    protected function fetchModelScopes($model)
    {
        $reflection = new \ReflectionClass($model);

        foreach ($reflection->getMethods() as $method) {
            if (preg_match('~^scope(.+)$~i', $method->name, $match)) {
                $name = $match[1];

                if ($this->isDynamicScope($method)) {
                    continue;
                }

                if ($this->isHiddenScope($name)) {
                    continue;
                }

                if ($this->hasHiddenFlag($method->getDocComment())) {
                    continue;
                }

                $this->addScope($name, $name);
            }
        }
    }

    /**
     * @param $method
     * @return int
     */
    protected function isDynamicScope($method)
    {
        return count($method->getParameters()) > 1;
    }

    /**
     * Exists in user-defined hiddenScopes property
     *
     * @param $name
     * @return bool
     */
    protected function isHiddenScope($name)
    {
        return property_exists($this, 'hiddenScopes') && in_array($name, $this->hiddenScopes);
    }

    /**
     * Marked with @hidden flag
     *
     * @param $docBlock
     * @return int
     */
    protected function hasHiddenFlag($docBlock)
    {
        return preg_match('~\@hidden~si', $docBlock);
    }

    /**
     * Add a scope
     *
     * @param  $name
     * @param  $method
     * @return $this
     */
    public function addScope($name, $method)
    {
        if (! $name) {
            $name = $this->humanize($method);
        }

        $this->scopes[str_slug($name, '_')] = [
            'name'     => $name,
            'callback' => $method
        ];

        return $this;
    }

    protected function humanize($name)
    {
        return StringHumanizer::humanize($name);
    }

    /**
     * Add SoftDeletes scopes if model uses that trait
     *
     * @param $model
     */
    protected function addSoftDeletesScopes($model)
    {
        if (method_exists($model, 'withTrashed')) {
            foreach (['onlyTrashed' => "Only Trashed", 'withTrashed' => "With Trashed"] as $method => $name) {
                $this->addScope($name, $method);
            }
        }
    }
}
