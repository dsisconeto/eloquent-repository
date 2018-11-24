<?php

namespace DSisconeto\EloquentRepository;

/**
 * Interface RepositoryInterface
 * @package DSisconeto\EloquentRepositor
 */
interface RepositoryInterface
{
    /**
     * @param $entity
     */
    public function store($entity): void;

    /**
     * @param $entity
     */
    public function update($entity): void;

    /**
     * @param $primaryKey
     */
    public function delete($primaryKey): void;

    /**
     * @param $primaryKey
     * @param array $includes
     * @return null|object|mixed
     */
    public function findById($primaryKey, $includes = []): ?object;

    /**
     * @param array $includes
     * @param array $order
     * @return \ArrayObject
     */
    public function findAll($includes = [], $order = []): \ArrayObject;

    /**
     * @param $primaryKey
     * @return bool
     */
    public function has($primaryKey): bool;

    /**
     * @return int
     */
    public function count(): int;
}
