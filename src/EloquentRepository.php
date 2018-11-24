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
    private $model;

    /**
     * EloquentRepository constructor.
     * @param AbstractMapper $model
     */
    public function __construct(AbstractMapper $model)
    {
        $this->model = $model;
    }

    /**
     * @param $entity
     */
    public function store($entity): void
    {
        $this->factoryModel($entity)->save();
    }

    /**
     * @param $entity
     */
    public function update($entity): void
    {
        $this->factoryModel($entity)->update();
    }

    /**
     * @param $primaryKey
     * @param array $includes
     * @return null|object
     */
    public function findById($primaryKey, $includes = []): ?object
    {
        /**
         * @var AbstractMapper $model
         */
        $model = $this->model->newQuery()->with($includes)->find($primaryKey);

        return is_null($model) ? null : $model->toEntity();
    }

    /**
     * @param array $includes
     * @param array $order
     * @return \ArrayObject
     */
    public function findAll($includes = [], $order = []): \ArrayObject
    {
        $query = $this->model->newQuery()->with($includes);

        if (array_key_exists(0, $order) && array_key_exists(1, $order)) {
            $query->orderBy($order[0], $order[1]);
        }

        return $this->factoryEntityByCollection($query->get());
    }

    /**
     * @param $primaryKey
     * @return bool
     */
    public function has($primaryKey): bool
    {
        return $this->query()->where($this->model->getKeyName(), "=", $primaryKey)->exists();
    }

    /**
     * @param $primaryKey
     * @throws \Exception
     */
    public function delete($primaryKey): void
    {
        $this->factoryModel([$this->model->getKeyName() => $primaryKey])->delete();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->model->newQuery();
    }

    /**
     * @param $entity
     * @return AbstractMapper
     */
    public function factoryModel($entity): AbstractMapper
    {
        return $this->model->newInstance($this->model->toAttributes($entity), true);
    }

    /**
     * @param Collection $collection
     * @return \ArrayObject
     */
    public function factoryEntityByCollection(Collection $collection): \ArrayObject
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

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->query()->count();
    }
}
