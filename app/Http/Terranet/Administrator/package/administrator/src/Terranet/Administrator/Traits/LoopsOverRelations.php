<?php

namespace Terranet\Administrator\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Terranet\Administrator\Exception;

trait LoopsOverRelations
{
    /**
     * Loops over provided relations to fetch value
     *
     * @param        $eloquent
     * @param string $name
     * @param array $relations
     * @param bool $format
     * @return mixed
     * @throws Exception
     */
    protected function fetchRelationValue($eloquent, $name, array $relations = [], $format = false)
    {
        $object = clone $eloquent;

        while ($relation = array_shift($relations)) {
            $object = call_user_func([$object, $relation]);

            if ($object instanceof BelongsToMany) {
                return $object->lists($object->getOtherKey())->toArray();
            }

            if (!($object instanceof HasOne || $object instanceof BelongsTo)) {
                throw new Exception('Only HasOne and BelongsTo relations supported');
            }

            $ttl = app('scaffold.config')->get('cache.relations', null);
            $cacheKey = sprintf("%s.%d", $relation, $object->getParent()->getAttribute($object->getForeignKey()));
            $object = app('cache')->remember($cacheKey, $ttl, function () use ($object) {
                return $object->getResults();
            });
        }

        return ($object && is_object($object)) ? ($format ? \admin\helpers\eloquent_attribute($object, $name) : $object->$name) : null;
    }
}
