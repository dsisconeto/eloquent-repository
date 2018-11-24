<?php

namespace DSisconeto\EloquentRepository;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentRepository
 * @package DSisconeto\EloquentRepository
 */
class EloquentRepository implements RepositoryInterface
{
    /**
     * @var AbstractMapper
     */
    private $mapper;

    /**
     * EloquentRepository constructor.
     * @param AbstractMapper $mapper
     */
    public function __construct(AbstractMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param mixed|object $entity
     */
    public function store(object $entity): void
    {
        $this->toMapper($entity, false)->save();
    }

    /**
     * @param mixed|object $entity
     */
    public function update(object $entity): void
    {
        $this->toMapper($entity, true)->update();
    }

    /**
     * @param string $key
     * @param array $includes
     * @return null|object
     */
    public function findById(string $key, array $includes = []): ?object
    {
        /**
         * @var AbstractMapper $model
         */
        $model = $this->mapper->newQuery()->with($includes)->find($key);

        return is_null($model) ? null : $model->toEntity();
    }

    /**
     * @param array $includes
     * @param array $order
     * @return \ArrayObject
     */
    public function findAll(array $includes = [], array $order = []): \ArrayObject
    {
        $query = $this->mapper->newQuery()->with($includes);

        if (array_key_exists(0, $order) && array_key_exists(1, $order)) {
            $query->orderBy($order[0], $order[1]);
        }

        return $this->toEntities($query->get());
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->query()->where($this->mapper->getKeyName(), "=", $key)->exists();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->query()->count();
    }

    /**
     * @param string $key
     * @throws \Exception
     */
    public function delete(string $key): void
    {
        $this->newInstance([$this->mapper->getKeyName() => $key], true)->delete();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->mapper->newQuery();
    }

    /**
     * @param object $entity
     * @param bool $exists
     * @return AbstractMapper
     */
    public function toMapper(object $entity, bool $exists): AbstractMapper
    {
        return $this->newInstance($this->mapper->toAttributes($entity), $exists);
    }

    public function newInstance(array $attributes, bool $exists): AbstractMapper
    {
        return $this->mapper->newInstance($attributes, $exists);
    }

    /**
     * @param Collection $collection
     * @return \ArrayObject
     */
    public function toEntities(Collection $collection): \ArrayObject
    {
        $array = new \ArrayObject();
        /**
         * @var AbstractMapper $model
         */

        foreach ($collection as $model) {
            $array->append($model->toEntity());
        }

        return $array;
    }
}
