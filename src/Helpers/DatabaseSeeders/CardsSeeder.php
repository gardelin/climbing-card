<?php

namespace ClimbingCard\Helpers\DatabaseSeeders;

use ClimbingCard\Repositories\Cards;

class CardsSeeder
{
    /**
     * Fill new cards table with old table data (wp_ekarton_podaci)
     *
     * @return void
     */
    public function run()
    {
        $cardsRepository = Cards::getInstance();

        // Run only if cards table is empty
        if ($cardsRepository->count() > 0) {
            return;
        }

        $oldRecords = $cardsRepository->getRecordsFromOldTable();

        foreach ($oldRecords as $record) {
            $user = get_user_by('login', $record['userName']);

            // User doesn't exist
            if (!isset($user->ID))
                continue;

            $climbedAt = date("Y-m-d", strtotime($record['datum']));

            $data = [
                'user_id' => $user->ID,
                'route' => $record['smjer'],
                'grade' => $record['ocjena'],
                'crag' => $record['penjaliste'],
                'style' => $record['nacin'],
                'comment' => !empty($record['komentar']) ? $record['komentar'] : null,
                'climbed_at' => $climbedAt,
                'created_at' => $record['datum_upisa'],
                'updated_at' => $record['datum_upisa'],
            ];

            $cardsRepository->insert($data);
        }
    }
}
