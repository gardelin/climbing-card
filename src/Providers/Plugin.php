<?php

namespace ClimbingCard\Providers;

class Plugin
{
    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init()
    {
        // handle database upgrades
        add_action('admin_init', [new Database, 'run']);

        // fill database with necessary data
        add_action('admin_init', [new Seeder, 'run']);

        // Register routes
        add_action('init', [new Routes, 'register']);

        // Load translations
        add_action('init', [$this, 'loadPluginTextDomain']);

        // Add assets
        add_action('init', [new Assets, 'init']);

        // Register page templates
        add_action('init', [new PageTemplates, 'init']);

        // Load shortcodes rendering
        add_action('init', [new Shortcodes, 'init']);
    }

    /**
     * Load the plugin text domain for translation.
     */
    public function loadPluginTextDomain()
    {
        $domain = 'opp';
        $locale = apply_filters('plugin_locale', get_locale(), $domain);

        load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo');
        load_plugin_textdomain($domain, FALSE, CLIMBING_CARD_PATH . '/lang/');
    }
}
