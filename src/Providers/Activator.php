<?php

namespace ClimbingCard\Providers;

class Activator
{
    /**
     * Triggered when activating the plugin
     *
     * @param string $plugin
     * @return void
     */
    public static function activate($plugin)
    {
        if (strpos(plugin_basename(CLIMBING_CARD_FILE), 'activation') !== false) {
            // Flush the rewrite rules
            flush_rewrite_rules();
        }
    }

    /**
     * Triggered after the plugin has been activated
     *
     * @param string $plugin
     * @return void
     */
    public static function afterActivate($plugin) {}
}
