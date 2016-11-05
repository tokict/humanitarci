<?php

namespace Terranet\Administrator\Traits\Module;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Doctrine\DBAL\Schema\Column;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Terranet\Administrator\Traits\MethodsCollector;
use Terranet\Translatable\Translatable;

trait HasForm
{
    use MethodsCollector;

    /**
     * Provides array of editable columns
     *
     * @return array
     */
    public function form()
    {
        return $this->scaffoldForm();
    }

    /**
     * Build editable columns based on table columns metadata
     *
     * @return array
     */
    protected function scaffoldForm()
    {
        $model = $this->model();

        $editable = array_merge(
            [],
            $translatable = $this->scaffoldTranslatable($model),
            $model->getFillable()
        );

        foreach ($this->collectMethods($model) as $method) {
            if ($results = $this->hasCommentFlag('editable', $method)) {
                $relation = call_user_func([$model, $method->getName()]);

                if ($relation instanceof HasOne) {
                    foreach ($relation->getRelated()->getFillable() as $relationColumn) {
                        array_push($editable, "{$method->getName()}.{$relationColumn}");
                    }
                }
            }
        }
        
        return array_build($editable, function ($key, $column) use ($model, $translatable) {
            $type = $this->inputType($column, $model);

            if (is_string($type)) {
                $type = ['type' => $type];
            }

            if (in_array($column, $translatable)) {
                $type['translatable'] = true;
            }

            if ($model instanceof StaplerableInterface && array_key_exists($column, $model->getAttachedFiles())) {
                $type['type'] = count($model->$column->styles) > 1 ? 'image' : 'file';
            }

            // detect enums

            if (array_has($type, 'type') && 'select' == $type['type']) {
                $options = $this->getEnumValues($model->getTable(),$column );

                $type['options'] = [];
                foreach ($options as $key =>  $option) {
                    $type['options'][$key] = ucfirst($option);
                }

            }

            return [$column, $type];
        });
    }


    public static function getEnumValues($table, $column)
    {
        $type = DB::select( DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'") )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();;
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            $enum[] = $v;
        }
        return $enum;
    }

    /**
     * @param $column
     * @param $eloquent
     * @return string
     */
    protected function inputType($column, $eloquent)
    {
        static $columns = [];

        if (method_exists($this, 'inputTypes') && ($types = $this->inputTypes())) {
            if (array_key_exists($column, $types)) {
                return $types[$column];
            }
        }

        // detect attachments
        if ($eloquent instanceof StaplerableInterface && ($attachments = $eloquent->getAttachedFiles())) {
            if ($this->isAttachment($column, $attachments)) {
                return $this->getAttachmentType($column, $attachments);
            }
        }

        $columns = array_merge($columns, $this->allColumns($eloquent));

        // map column database type to type
        if ($column = array_get($columns, $column)) {
            return $this->mapColumnTypeToFieldType($column);
        }

        if ($chain = $this->isRelationColumn($column)) {
            list($relColumn, $table) = $this->resolveRelationsChain($chain, $eloquent);

            return $this->inputType($relColumn, $table->getRelated());
        }

        return 'text';
    }

    protected function resolveRelationsChain($chain, $eloquent)
    {
        $relColumn = array_pop($chain);

        $table = array_reduce($chain, function($table, $object) use ($eloquent) {
            if (! $table) {
                $table = $eloquent;
            }

            return $table = call_user_func([$table, $object]);
        }, null);

        return [$relColumn, $table];
    }

    protected function mapColumnTypeToFieldType(Column $column)
    {
        switch ($this->columnType($column)) {
            case 'StringType':
                if (db_connection('mysql') && null === $column->getLength()) {
                    return 'select';
                }
                return 'text';

            case 'GuidType':
                return 'text';

            case 'TextType':
                return 'textarea';

            case 'BooleanType':
                return 'boolean';

            case 'IntegerType':
            case 'BigIntType':
            case 'DecimalType':
            case 'FloatType':
                return 'number';

            case 'DateTimeType':
            case 'DateTimeTzType':
                return 'datetime';

            case 'DateType':
                return 'date';
        }

        return 'text';
    }

    /**
     * @param $column
     * @return string
     */
    protected function columnType(Column $column)
    {
        return class_basename($column->getType());
    }

    /**
     * @param $column
     * @param $attachments
     * @return bool
     */
    protected function isAttachment($column, $attachments)
    {
        return array_key_exists($column, $attachments);
    }

    /**
     * @param $column
     * @param $attachments
     * @return array
     */
    protected function getAttachmentType($column, $attachments)
    {
        $type = count($attachments[$column]->getConfig()->styles) <= 1 ? 'file' : 'image';

        return ['type' => $type];
    }

    protected function scaffoldTranslatable($model)
    {
        if ($model instanceof Translatable) {
            return $model->getTranslatedAttributes();
        }

        return [];
    }

    /**
     * @param $eloquent
     * @return array
     */
    protected function allColumns($eloquent)
    {
        static $columns = [];

        $table = is_object($eloquent) ? $eloquent->getTable() : $eloquent;

        if (! array_has($columns, $table) || empty($columns)) {
            $columns[$table] = app('scaffold.schema')->columns($table);

            if ($eloquent instanceof Translatable && ($eloquent->getTranslatedAttributes())) {
                $translationModel = $eloquent->getTranslationModel();

                $columns[$table] = array_merge($columns[$table], app('scaffold.schema')->columns($translationModel->getTable()));
            }
        }

        return $columns[$table];
    }

    /**
     * @param $column
     * @return bool
     */
    protected function isRelationColumn($column)
    {
        return count($chain = explode('.', $column)) > 1 ? $chain : false;
    }
}
