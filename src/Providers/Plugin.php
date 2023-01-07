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

        // Add assets
        add_action('init', [new Assets, 'init']);

        // Register page templates
        add_action('init', [new PageTemplates, 'init']);

        // Load shortcodes rendering
        add_action('init', [new Shortcodes, 'init']);

        // Set changes to wordpress registration form
        add_action('init', [new Registration, 'init']);
    }
}
