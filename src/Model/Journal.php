<?php

namespace ClimbingCard\Model;

use ClimbingCard\Model\Contracts\RepositoryAccess;
use ClimbingCard\Repositories\Journals;
use ClimbingCard\Services\DataObject;

/**
 * @property int $id_podatak
 * @property int $userName
 * @property string $smjer
 * @property string $ocjena
 * @property string $penjaliste
 * @property string $nacin
 * @property string $datum
 * @property string $datum_upisa
 */
class Journal extends DataObject implements RepositoryAccess
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
        'id_podatak' => 'int',
    ];

    /**
     * Return model repository.
     *
     * @return Journals
     */
    public static function getRepository()
    {
        return Journals::getInstance();
    }
}
