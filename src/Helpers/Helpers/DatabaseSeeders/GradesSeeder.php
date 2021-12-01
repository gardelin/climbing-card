<?php

namespace ClimbingCard\Helpers\DatabaseSeeders;

use ClimbingCard\Repositories\Grades;

class GradesSeeder
{
    /**
     * Fill grades table
     *
     * @return void
     */
    public function run()
    {
        $repository = (new Grades);

        // Fill old table only if new table is empty
        if ($repository->getCount() > 0)
            return;

        $repository->create([
            'name' => 'project',
        ]);

        $numbers = [
            0 => 4,
            1 => 5,
            2 => 6,
            3 => 7,
            4 => 8,
            5 => 9,
        ];

        foreach ($numbers as $key => $number) {
            $letters = ["a", "a+", "a/a+", "a+/b", "b", "b+", "b/b+", "b+/c", "c", "c/c+", "c+"];

            foreach ($letters as $letter) {
                $repository->create([
                    'name' => $number . $letter,
                ]);

                if ($letter === "c+" && isset($numbers[$key + 1])) {
                    $repository->create([
                        'name' => $number . $letter . "/" . $numbers[$key + 1] . "a",
                    ]);
                }
            }
        }
    }
}
