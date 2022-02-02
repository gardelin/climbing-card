<?php

namespace ClimbingCard\Shortcodes;

use ClimbingCard\Repositories\Cards;
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
        $stats = Cards::getInstance()->stats();

        return view('cards/stats-counter', ['stats' => $stats], false);
    }
}
