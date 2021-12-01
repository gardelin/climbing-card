<?php

namespace ClimbingCard\Helpers\DatabaseSeeders;

use ClimbingCard\Repositories\Journals;

class JournalsSeeder
{
    /**
     * Fill new journals table with old journals table data (wp_ekarton_podaci)
     *
     * @return void
     */
    public function run()
    {
        $journals = (new Journals);

        // Fill old table only if new table is empty
        if ($journals->getCount() > 0)
            return;


        $journals->create([]);
    }
}
