<?php

namespace DSisconeto\EloquentRepository;

/**
 * Interface RepositoryInterface
 * @package DSisconeto\EloquentRepositor
 */
interface RepositoryInterface
{
    /**
     * @param object|mixed $entity
     */
    public function store(object $entity): void;

    /**
     * @param object|mixed $entity
     */
    public function update(object $entity): void;

    /**
     * @param string $key
     */
    public function delete(string $key): void;

    /**
     * @param string $key
     * @param array $includes
     * @return null|object|mixed
     */
    public function findById(string $key, array $includes = []): ?object;

    /**
     * @param array $includes
     * @param array $order
     * @return \ArrayObject
     */
    public function findAll(array $includes = [], array $order = []): \ArrayObject;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @return int
     */
    public function count(): int;
}
