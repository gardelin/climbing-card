<?php

namespace ClimbingCard\Model;

use ClimbingCard\Model\Contracts\RepositoryAccess;
use ClimbingCard\Repositories\Cards;
use ClimbingCard\Services\DataObject;

/**
 * @property int $id
 * @property int $user_id
 * @property string $route
 * @property string $grade
 * @property string $crag
 * @property string $style
 * @property string $climbed_at
 */
class Card extends DataObject implements RepositoryAccess
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Property cast types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
    ];

    /**
     * Return model repository.
     *
     * @return Cards
     */
    public static function getRepository()
    {
        return Cards::getInstance();
    }
}
