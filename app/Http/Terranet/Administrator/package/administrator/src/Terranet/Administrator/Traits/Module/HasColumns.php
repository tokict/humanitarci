<?php

namespace Terranet\Administrator\Traits\Module;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Terranet\Translatable\Translatable;

trait HasColumns
{
    /**
     * Fetch scaffold columns
     *
     * @return array
     */
    public function columns()
    {
        return $this->scaffoldColumns();
    }

    /**
     * Scaffold columns
     *
     * @return array
     */
    protected function scaffoldColumns()
    {
        return $this->decorateAttachments($model = $this->model(), $this->collectColumns($model));
    }

    /**
     * @param $model
     * @param $columns
     * @return mixed
     */
    protected function decorateAttachments($model, $columns)
    {
        if ($model instanceof StaplerableInterface) {
            $attachments = $model->getAttachedFiles();
            foreach ($columns as $column => $attributes) {
                if (array_key_exists($column, $attachments)) {
                    $columns[$column] = array_merge((array)$attributes, [
                        'output' => function ($row) use ($column) {
                            return \admin\output\staplerImage($row->$column);
                        },
                    ]);
                }
            }
        }

        return $columns;
    }

    /**
     * @param $model
     * @return array
     */
    protected function collectColumns($model)
    {
        $fillable = $model->getFillable();

        $columns = array_merge([$model->getKeyName()], $fillable);
        $columns = array_flip($columns);
        $columns = $this->filterHiddenColumns($model, $columns);
        $columns = $this->decorateOutput($columns);

        if ($translatable = $this->scaffoldTranslatableColumns($model)) {
            $columns = array_merge($columns, $translatable);
        }

        if ($this->includeDateColumns && ($dates = $model->getDates())) {
            $columns = array_merge($columns, [
                'Dates' => ['elements' => $this->decorateOutput(array_flip(
                    array_diff($dates, array_keys($columns))
                ))],
            ]);
        }

        return $columns;
    }

    /**
     * @param $model
     * @param $columns
     * @return array
     */
    protected function filterHiddenColumns($model, $columns)
    {
        $hidden = $model->getHidden();

        if (property_exists($this, 'hideColumns')) {
            $hidden = array_merge($hidden, (array)$this->hideColumns);
        }

        return array_unique(array_filter($columns, function ($index, $column) use ($hidden) {
            return ! in_array($column, $hidden);
        }, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * @param $columns
     * @return array
     */
    protected function decorateOutput($columns)
    {
        $tableColumns = $this->fetchTableColumns($this->model()->getTable());

        foreach ($columns as $column => &$index) {
            $index = $this->realColum($column, $tableColumns)
                ? $this->decorateByType($tableColumns, $column)
                : $this->defaultDecorator($column);
        }

        return $columns;
    }

    protected function fetchTableColumns($table)
    {
        return app('scaffold.schema')->columns($table);
    }

    /**
     * @param $column
     * @return array
     */
    protected function booleanDecorator($column)
    {
        return
            [
                'output' => function ($row) use ($column) {
                    return \admin\output\boolean($row->{$column});
                }
            ];
    }

    /**
     * @param $className
     * @param $column
     * @return array
     */
    protected function dateTimeDecorator($className, $column)
    {
        $method = "to" . str_replace('Type', '', $className) . "String";

        return
            [
                'output' => function ($row) use ($column, $method) {
                    $callable = [$this->presentValue($row, $column), $method];

                    return is_callable($callable) ? call_user_func($callable) : $this->presentValue($row, $column);
                }
            ];
    }

    protected function defaultDecorator($column)
    {
        return
            [
                'output' => function ($row) use ($column) {
                    if ($value = $row->$column) {
                        return $this->presentValue($row, $column);
                    }
                    return null;
                }
            ];
    }

    /**
     * Collect translatable columns
     *
     * @param $model
     * @return array
     */
    protected function scaffoldTranslatableColumns($model)
    {
        if ($model instanceof Translatable) {
            return array_build($model->getTranslatedAttributes(), function ($index, $column) {
                return [
                    $column,
                    [
                        'output' => function ($row) use ($column) {
                            if ($value = $row->$column) {
                                return $this->presentValue($row, $column);
                            }

                            return null;
                        },
                    ],
                ];
            });
        }

        return [];
    }

    /**
     * @param $column
     * @param $tableColumns
     * @return bool
     */
    protected function realColum($column, $tableColumns)
    {
        return array_key_exists($column, $tableColumns);
    }

    /**
     * @param $tableColumns
     * @param $column
     * @return array
     */
    protected function decorateByType($tableColumns, $column)
    {
        $columnInfo = $tableColumns[$column];

        switch ($className = class_basename($columnInfo->getType())) {
            case 'BooleanType':
                return $this->booleanDecorator($column);

            case 'TimeType':
            case 'DateType':
            case 'DateTimeType':
                return $this->dateTimeDecorator($className, $column);
        }

        return $this->defaultDecorator($column);
    }

    protected function presentValue($row, $column)
    {
        return \admin\helpers\eloquent_attribute($row, $column);
    }
}
