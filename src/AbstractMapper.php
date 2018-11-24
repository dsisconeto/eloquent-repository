<?php

namespace DSisconeto\EloquentRepository;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractMapper
 * @package DSisconeto\EloquentRepository
 */
abstract class AbstractMapper extends Model
{
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var string
     */
    protected $keyType = 'string';
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @return object|mixed
     */
    abstract public function toEntity(): object;

    /**
     * @param $entity
     * @return array
     */
    abstract public function toAttributes($entity): array;
}
