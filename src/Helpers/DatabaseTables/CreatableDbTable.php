<?php

namespace ClimbingCard\Helpers\DatabaseTables;

interface CreatableDbTable
{
    /**
     * Creates and updates table.
     *
     * @return void
     */
    public function setup();

    /**
     * Returns fully qualified table name.
     *
     * @return string
     */
    public static function getTableName();
}
