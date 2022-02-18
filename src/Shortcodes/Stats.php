<?php

namespace ClimbingCard\Shortcodes;

use ClimbingCard\Repositories\Cards;
use function ClimbingCard\view;

class Stats
{
    /**
     * Calculate climbing card statistics and display it as list
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

        return view('cards/stats', ['stats' => $stats], false);
    }
}
