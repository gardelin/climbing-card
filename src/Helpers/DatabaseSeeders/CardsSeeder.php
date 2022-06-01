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

            $data = [
                'user_id' => $user->ID,
                'route' => $record['smjer'],
                'grade' => $record['ocjena'],
                'crag' => $record['penjaliste'],
                'style' => $record['nacin'],
                'comment' => !empty($record['komentar']) ? $record['komentar'] : null,
                'climbed_at' => $this->generalizeDateString($record['datum']),
                'created_at' => $record['datum_upisa'],
                'updated_at' => $record['datum_upisa'],
            ];

            $cardsRepository->insert($data);
        }
    }

    /**
     * Convert old date string to same format (YYYY-MM-DD)
     * 
     * @param string $dateStr
     * @return string
     */
    private function generalizeDateString($dateStr)
    {
        $old = $dateStr;
        $dateStr = str_replace([' '], '.', $dateStr);
        $dateStr = str_replace([',', '..'], '.', $dateStr);
        $dateStr = str_replace('o', '0', $dateStr);
        $dateStr = str_replace(['´'], '', $dateStr);
        $dateStr = str_replace(['xx'], '01', $dateStr);
        $dateStr = str_replace(['mj'], '01', $dateStr);
        $dateStr = rtrim($dateStr, '.');

        // Special cases
        if ($dateStr == '07.2011')
            $dateStr = '01.07.2011';
        if ($dateStr == '2210.06')
            $dateStr = '22.10.06';
        if ($dateStr == '080.04.2009')
            $dateStr = '08.04.2009';
        if ($dateStr == '2005')
            $dateStr = '01.01.2005';
        if ($dateStr == '2009')
            $dateStr = '01.01.2009';
        if ($dateStr == '2010')
            $dateStr = '01.01.2010';
        if ($dateStr == '2011')
            $dateStr = '01.01.2011';
        if ($dateStr == '030606')
            $dateStr = '03.06.2006';

        $dateParts = explode('.', $dateStr);

        // Check Year
        // Convert 06 to 2006
        if (isset($dateParts[2]) && strlen($dateParts[2]) == 2) {
            $dateParts[2] = '20' . $dateParts[2];
        }

        $dateStr = join('.', $dateParts);

        $dateStr = date("Y-m-d", strtotime($dateStr));

        return $dateStr;
    }
}
