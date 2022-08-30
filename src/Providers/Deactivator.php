<?php

namespace ClimbingCard\Providers;

class Deactivator
{
    /**
     * Triggered when deactivating the plugin
     *
     * @param string $plugin
     * @return void
     */
    public static function deactivate($plugin)
    {
        // Flush the rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Triggered after the plugin has been deactivated
     *
     * @param string  $plugin
     * @return void
     */
    public static function afterDeactivate($plugin) {}
}
