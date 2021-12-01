<?php

namespace ClimbingCard\Helpers\DatabaseSeeders;

use ClimbingCard\Repositories\Sectors;
use ClimbingCard\Repositories\OldJournals;

class SectorsSeeder
{
    /**
     * Fill sectors table using old data from wp_ekarton_podaci
     *
     * @return void
     */
    public function run()
    {
        $repository = (new Sectors);

        // Fill old table only if new table is empty
        if ($repository->getCount() > 0)
            return;

        $oldJournals = (new OldJournals())->all();

        // $sectors = [];
        // foreach ($oldJournals as $oldJournal) {
        //     $name = $oldJournal->penjaliste;

        //     if (is_int($name))
        //         continue;

        //     array_push($sectors, strtolower($name));
        // }

        // $sectors = array_unique($sectors);

        // sort($sectors);

        // error_log(print_r($sectors, true));
    }
}
