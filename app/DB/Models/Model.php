<?php

namespace App\DB\Models;

use App\DB\ArrayGenerators\ArrayGenerator;
use Carbon\Carbon;
use App\DB\EloquentRepositories\EloquentRepository;

/**
 * @property ?Carbon $createdAt
 * @property ?Carbon $updatedAt
*/
abstract class Model extends BaseModel
{
    /**
     * Every model should have dedicated
     * repository implemented
     *
     * @return EloquentRepository
     */
    public static abstract function repository(): EloquentRepository;

    /**
     * Every model should have dedicated
     * array generator implemented
     *
     * @return ArrayGenerator
     */
    public abstract function arrayGenerator(): ArrayGenerator;

    /**
     * Database connection
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Changing eloquent's default field name
     *
     * @var string
     */
    const CREATED_AT = 'createdAt';

    /**
     * Changing eloquent's default field name
     *
     * @var string
     */
    const UPDATED_AT = 'updatedAt';
}
