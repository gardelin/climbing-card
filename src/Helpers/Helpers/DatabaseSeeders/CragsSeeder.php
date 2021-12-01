<?php

namespace ClimbingCard\Helpers\DatabaseSeeders;

use ClimbingCard\Repositories\Crags;
use ClimbingCard\Repositories\Sectors;
use ClimbingCard\Repositories\Routes;
use ClimbingCard\Repositories\Grades;
// use ClimbingCard\Repositories\OldJournals;
use PHPHtmlParser\Dom;

class CragsSeeder
{
    /**
     * Plezanje.net url
     */
    const PLEZANJE =  'https://www.plezanje.net/climbing/db/';

    /**
     * Fill crags table
     *
     * @return void
     */
    public function run()
    {
        // $oldJournals = (new OldJournals())->all();

        // $a = [];
        // $crags = [];
        // foreach ($oldJournals as $oldJournal) {
        //     $name = $oldJournal->penjaliste;

        //     if (\is_numeric($name)) {
        //         continue;
        //     }

        //     // Replace special chars
        //     $name = str_replace(['ÄŒ', 'Ä‡', 'Ä', 'Å¾', 'Ä‡', 'Å' ], ['č', 'č', 'č', 'ž', 'š', 'š'], $name);
        //     // Escape croatian special chars
        //     $escaped = strtr($name, ['č' => 'c', 'ć' => 'c', 'š' => 's', 'ž '=> 'z', 'Č' => 'C', 'Ć' => 'C', 'Ž' => 'Z', 'Š' => 'S', ' ' => '', 'ž' => 'z', ]);
        //     // Lower string
        //     $name = strtolower(trim($name));
        //     $escaped = strtolower(trim($escaped));
        //     // error_log($name . " " . $escaped);

        //     if (! in_array($escaped, $a)) {
        //         array_push($a, $escaped);
        //         array_push($crags, $name);
        //     }
        // }
        // $a = array_unique($a);
        // sort($a);
        // error_log(print_r($a, true));

        // $crags = array_unique($crags);

        // sort($crags);

        // error_log(print_r($crags, true));
    }
}
