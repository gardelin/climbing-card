<?php

namespace ClimbingCard\Providers;

use function ClimbingCard\is_admin_screen;

class Assets
{
    /**
     * Triggered when deactivating the plugin
     *
     * @return void
     */
    public function init()
    {
        // Then add the assets
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_body_class', [$this, 'appendBodyClassToAdminPages']);
    }

    /**
     * Add specific class for to <body> for plugin admin pages
     * 
     * @param string $classes
     * @return string
     */
    public function appendBodyClassToAdminPages($classes)
    {
        if (is_admin_screen()) {
            $classes .= ' climbing-card-admin-app ';
        }

        return $classes;
    }

    /**
     * Enqueue admin scripts and styles
     *
     * @param string $page
     * @return void
     */
    public function enqueueAdminScripts($page)
    {
        if (!is_admin_screen())
            return;

        wp_enqueue_script('climbingcard-admin-js', plugins_url('public/assets/js/admin.js', CLIMBING_CARD_FILE), [], CLIMBING_CARD_VERSION, true);
        wp_localize_script(
            'jquery',
            'climbingcards',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'rest_url' => get_rest_url() . 'climbingcard/v1/',
                'nonce' => wp_create_nonce('wp_rest'),
                'logged_user_id' => get_current_user_id(),
                'page_language' => get_locale(),
                'user_language' => get_user_locale(),
            ]
        );

        wp_enqueue_style('climbingcard-admin-css', plugins_url('public/assets/css/admin.css', CLIMBING_CARD_FILE), [], CLIMBING_CARD_VERSION);
        wp_enqueue_style('climbingcard-google-font', 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap', false);
    }

    /**
     * Enqueue frontend scripts and styles.
     *
     * @param string $page
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_style('climbingcard-frontend-css', plugins_url('public/assets/css/frontend.css', CLIMBING_CARD_FILE), [], CLIMBING_CARD_VERSION);
        wp_enqueue_script('climbingcard-frontend-js', plugins_url('public/assets/js/frontend.js', CLIMBING_CARD_FILE), [], CLIMBING_CARD_VERSION, true);

        wp_localize_script(
            'climbingcard-frontend-js',
            'climbingcards',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'rest_url' => get_rest_url() . 'climbingcard/v1',
                'nonce'    => wp_create_nonce('wp_rest'),
                'page_language' => get_locale(),
            ]
        );
    }
}
