<?php

namespace ClimbingCard\Shortcodes;

use ClimbingCard\Repositories\Journals;
use function ClimbingCard\view;

class LastClimbedRoutes
{
    /**
     * Render list of last n climbed routes
     *
     * @param  array  $attributes
     * @param  null  $content
     * @param  string  $tag
     * 
     * @return string
     */
    public static function render($attributes = [], $content = null): string
    {
        $number = isset($attributes['number']) ? (int) $attributes['number'] : 10;

        $journals = Journals::getInstance()->all(['limit' => $number]);

        return view('journal/last-climbed-routes', ['journals' => $journals], false);
    }
}
