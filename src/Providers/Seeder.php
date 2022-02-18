<?php

namespace ClimbingCard\Providers;

use ClimbingCard\Helpers\DatabaseSeeders\CardsSeeder;

class Seeder
{
    /**
     * Fill database with data
     */
    public function run()
    {
        (new CardsSeeder)->run();
    }
}
