<?php

namespace ClimbingCard\Shortcodes;

use ClimbingCard\Repositories\Journals;
use function ClimbingCard\view;

class StatsCounter
{
    /**
     * Calculate climbing card statistics and display it as increment counter 
     *
     * @param  array  $attributes
     * @param  null  $content
     * @param  string  $tag
     * 
     * @return string
     */
    public static function render($attributes = [], $content = null): string
    {
        $stats = Journals::getInstance()->stats();

        return view('journal/stats-counter', ['stats' => $stats], false);
    }
}
