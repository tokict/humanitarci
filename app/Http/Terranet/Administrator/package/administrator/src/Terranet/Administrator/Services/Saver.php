<?php

namespace Terranet\Administrator\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Terranet\Administrator\Contracts\Services\Saver as SaverContract;
use Terranet\Administrator\Form\TranslatableElement;
use Terranet\Administrator\Form\Type\File;
use Terranet\Administrator\Form\Type\Image;
use Terranet\Administrator\Form\Type\Key;
use Terranet\Administrator\Requests\UpdateRequest;

class Saver implements SaverContract
{
    /**
     * Data collected during saving process
     *
     * @var array
     */
    protected $data = [];

    /**
     * List of relations queued for saving
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Main module repository
     *
     * @var Model
     */
    protected $repository;

    /**
     *
     * @var UpdateRequest
     */
    protected $request;

    /**
     * Saver constructor.
     *
     * @param               $eloquent
     * @param UpdateRequest $request
     */
    public function __construct($eloquent, UpdateRequest $request)
    {
        $this->repository = $eloquent;
        $this->request = $request;
    }

    /**
     * Process request and persist data
     *
     * @return mixed
     */
    public function sync()
    {
        $this->connection()->transaction(function () {
            foreach ($this->editable() as $field) {
                $name = $field->getName();

                if ($this->isKey($field) || $this->isTranslatable($field)) {
                    continue;
                }

                $this->collectRelations($field, $name);

                $value = $this->isFile($field) ? $this->request->file($name) : $this->request->get($name);

                $this->data[$name] = $value;
            }

            $this->collectTranslatable();

            $this->cleanData();

            Model::unguard();

            /*
            |-------------------------------------------------------
            | Save main data
            |-------------------------------------------------------
            */
            $this->save();

            /*
            |-------------------------------------------------------
            | Relationships
            |-------------------------------------------------------
            | Save related data, fetched by "relation" from related tables
            */
            $this->saveRelations();

            Model::reguard();
        });

        return $this->repository;
    }

    /**
     * Fetch editable fields
     *
     * @return mixed
     */
    protected function editable()
    {
        return app('scaffold.form')->getFields();
    }

    /**
     * @param $field
     * @return bool
     */
    protected function isKey($field)
    {
        return $field instanceof Key;
    }

    /**
     * @param $field
     * @return bool
     */
    protected function isTranslatable($field)
    {
        return $field instanceof TranslatableElement;
    }

    /**
     * @param $field
     * @return bool
     */
    protected function isFile($field)
    {
        return ($field instanceof File || $field instanceof Image);
    }

    /**
     * Protect request data against external data
     */
    protected function cleanData()
    {
        $this->data = array_except($this->data, [
            '_token',
            'save',
            'save_create',
            'save_return',
            $this->repository->getKeyName(),
        ]);

        // leave only fillable columns
        $this->data = array_only($this->data, $this->repository->getFillable());
    }

    /**
     * Persist data
     */
    protected function save()
    {
        $this->nullifyEmptyNullables($this->repository->getTable());

        $this->repository->fill($this->data)->save();
    }

    protected function saveRelations()
    {
        foreach ($this->relations as $relation => $values) {
            $relation = call_user_func([$this->repository, $relation]);

            if ($relation instanceof BelongsToMany) {
                $values = $this->forgetNullValues($relation, $values);
                $relation->sync($values);
            }

            if ($relation instanceof HasOne || $relation instanceof BelongsTo) {
                ($record = $relation->first())
                    ? $record->fill($values)->save()
                    : $relation->create($values);
            }
        }
    }

    /**
     * Remove null values from data
     *
     * @param $relation
     * @param $values
     * @return array
     */
    protected function forgetNullValues($relation, $values)
    {
        $keys = explode('.', $relation->getOtherKey());
        $key = array_pop($keys);

        return array_filter((array)$values[$key], function ($value) {
            return !is_null($value);
        });
    }

    /**
     * Collect relations for saving
     *
     * @param $field
     * @param $name
     */
    protected function collectRelations($field, $name)
    {
        if ($field instanceof HasOne && $field->hasRelation()) {
            $relation = $field->getRelation();
            $this->relations[$relation][$name] = $this->input($name);
        }

        if ($field->hasRelation()) {
            $relation = $field->getRelation();
            $this->relations[$relation][$name] = $this->input($name);
        }
    }

    /**
     * Collect translations
     */
    protected function collectTranslatable()
    {
        foreach ($this->request->get('translatable', []) as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Get database connection
     *
     * @return \Illuminate\Foundation\Application|mixed
     */
    protected function connection()
    {
        return app('db');
    }

    /**
     * Retrieve request input value
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function input($key, $default = null)
    {
        return app('request')->input($key, $default);
    }

    /**
     * Set empty "nullable" values to null
     *
     * @param $table
     * @return null
     */
    protected function nullifyEmptyNullables($table)
    {
        $columns = app('scaffold.schema')->columns($table);

        foreach ($this->data as $key => &$value) {
            if (!array_key_exists($key, $columns)) {
                continue;
            }

            if (!$columns[$key]->getNotnull() && empty($value)) {
                $value = null;
            }
        }
    }
}
