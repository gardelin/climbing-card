<?php

namespace ClimbingCard\Model\Contracts;

interface RepositoryAccess
{
    /**
     * Return model repository.
     *
     * @return  mixed
     */
    public static function getRepository();
}
