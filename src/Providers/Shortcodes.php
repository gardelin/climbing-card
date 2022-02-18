<?php

namespace ClimbingCard\Providers;

use ClimbingCard\Shortcodes\LastClimbedRoutes;
use ClimbingCard\Shortcodes\Stats;
use ClimbingCard\Shortcodes\StatsCounter;
use ClimbingCard\Shortcodes\TopUsersByNumberOfClimbedRoutes;

/**
 * Handle all builder shortcodes
 */
class Shortcodes
{
    /**
     * Init the editor backend
     */
    public static function init()
    {
        add_shortcode('last_climbed_routes', [LastClimbedRoutes::class, 'render']);
        add_shortcode('stats', [Stats::class, 'render']);
        add_shortcode('stats_counter', [StatsCounter::class, 'render']);
        add_shortcode('top_users_by_number_of_climbed_routes', [TopUsersByNumberOfClimbedRoutes::class, 'render']);
    }
}
