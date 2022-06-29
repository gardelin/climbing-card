<?php

namespace ClimbingCard\Repositories;

interface RepositoryAccess
{
    /**
     * Return model repository.
     *
     * @return  mixed
     */
    public static function getInstance();
}