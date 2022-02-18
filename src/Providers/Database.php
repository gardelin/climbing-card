<?php

namespace ClimbingCard\Providers;

use ClimbingCard\Helpers\DatabaseTables\CardsTable;

class Database
{
    /**
     * Run all needed DB updates according to db version.
     */
    public function run()
    {
        (new CardsTable)->setup();
    }
}
