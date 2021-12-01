<?php

namespace ClimbingCard\Helpers\DatabaseSeeders;

use ClimbingCard\Repositories\Journals;
use ClimbingCard\Repositories\Grades;
use ClimbingCard\Repositories\OldJournals;

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
        $grades = (new Grades);

        // Fill old table only if new table is empty
        if ($journals->getCount() > 0)
            return;

        $oldJournals = (new OldJournals())->all();

        foreach ($oldJournals as $oldJournal) {
            $user = get_user_by('login', $oldJournal->userName);

            if (!$user)
                continue;

            $journals->create([
                'id'         => $oldJournal->id_podatak,
                'user_id'    => $user->ID,
                'route_id'   => 1,
                'style'      => $oldJournal->nacin,
                'comment'    => $oldJournal->komentar,
                'climbed_at' => $oldJournal->datum_upisa,
                'created_at' => $oldJournal->datum,
            ]);
        }
    }
}
