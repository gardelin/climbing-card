<?php

namespace ClimbingCard\Providers;

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
    }

    /**
     * Enqueue admin scripts and styles
     *
     * @param string $page
     *
     * @return void
     */
    public function enqueueAdminScripts($page)
    {
        $currentScreen = get_current_screen();

        if (strpos($currentScreen->base, 'climbingcard') === false)
            return;

        wp_enqueue_script('climbingcard-legacy', plugins_url('public/assets/js/legacy.js', CLIMBING_CARD_FILE), ['jquery'], CLIMBING_CARD_VERSION, true);
        wp_enqueue_script('climbingcard-admin-js', plugins_url('public/assets/js/admin.js', CLIMBING_CARD_FILE), [], CLIMBING_CARD_VERSION, true);

        wp_localize_script(
            'climbingcard-js',
            'climbingcards',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'rest_url' => get_rest_url() . 'climbingcard/v1',
                'nonce'    => wp_create_nonce('wp_rest'),
            ]
        );

        wp_enqueue_style('climbingcard-css', plugins_url('public/assets/css/app.css', CLIMBING_CARD_FILE), [], CLIMBING_CARD_VERSION);
        wp_enqueue_style('climbingcard-frontend-css', plugins_url('public/assets/css/frontend.css', CLIMBING_CARD_FILE), [], CLIMBING_CARD_VERSION);
    }

    /**
     * Enqueue frontend scripts and styles.
     *
     * @param string $page
     *
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_style('climbingcard-frontend-css', plugins_url('public/assets/css/frontend.css', CLIMBING_CARD_FILE), [], CLIMBING_CARD_VERSION);
        wp_enqueue_script('climbingcard-frontend-js', plugins_url('public/assets/js/frontend.js', CLIMBING_CARD_FILE), ['jquery'], CLIMBING_CARD_VERSION);

        wp_localize_script(
            'climbingcard-frontend-js',
            'climbingCardWordpressData',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'rest_url' => get_rest_url() . 'climbingcard/v1',
                'nonce'    => wp_create_nonce('wp_rest'),
            ]
        );
    }
}
