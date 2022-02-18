<?php

namespace ClimbingCard\Providers;

use ClimbingCard\Services\Route;

class Routes
{
    /**
     * Register plugin routes
     *
     * @return void
     */
    public function register()
    {
        add_action('wp_loaded',     [$this, 'addAdminRoutes']);
        add_action('admin_menu',    [$this, 'registerRoutes']);
        add_action('rest_api_init', [$this, 'registerApiRoutes']);
    }

    /**
     * Include admin route definitions
     *
     * @return void
     */
    public function addAdminRoutes()
    {
        require CLIMBING_CARD_PATH . '/routes/admin.php';
    }

    /**
     * Register all added routes and admin pages
     *
     * @return void
     */
    public function registerRoutes()
    {
        Route::registerAdminPages();
    }

    /**
     * Include API route definitions
     *
     * @return void
     */
    public function registerApiRoutes()
    {
        require CLIMBING_CARD_PATH . '/routes/api.php';
    }
}
