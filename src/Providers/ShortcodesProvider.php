<?php

namespace ClimbingCard\Providers;

use ClimbingCard\Shortcodes\LastClimbedRoutes;

/**
 * Handle all builder shortcodes
 */
class ShortcodesProvider
{
    /**
     * Init the editor backend
     */
    public static function init()
    {
        add_shortcode('last_climbed_routes', [LastClimbedRoutes::class, 'render']);
    }
}
