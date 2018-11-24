<?php

namespace DSisconeto\EloquentRepository;


use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractMapper
 * @package DSisconeto\EloquentRepository
 */
abstract class AbstractMapper extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @return object
     */
    abstract public function toEntity(): object;

    /**
     * @param $entity
     * @return array
     */
    abstract public function toAttributes($entity): array;
}
