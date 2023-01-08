<?php

/**
 * Climbing Cartboard
 *
 * Plugin Name: Climbing Cartboard
 * Description: Wordpress plugin for managing climbed rock climbing routes
 * Plugin URI: https://github.com/rlabrovi/climbing-card
 * Author: Roko Labrovic
 * Version: 1.0.9
 * Author URI: https://github.com/rlabrovi
 * Text Domain: climbingcards
 * Domain Path: /resources/lang
 */

global $wpdb;

// Add autoloader
require_once __DIR__ . '/vendor/autoload.php';

define('CLIMBING_CARD_VERSION', '1.0.9');
define('CLIMBING_CARD_PLUGIN_SLUG', plugin_basename(__FILE__));
define('CLIMBING_CARD_FILE', __FILE__);
define('CLIMBING_CARD_PATH', __DIR__);
define('CLIMBING_CARD_URL', plugin_dir_url(__FILE__));

define('CLIMBING_CARD_PUBLIC_ASSET_PATH', CLIMBING_CARD_PATH . '/public/assets/');
define('CLIMBING_CARD_ASSET_PATH', CLIMBING_CARD_PATH . '/resources/assets/');
define('CLIMBING_CARD_PUBLIC_ASSETS_URL', CLIMBING_CARD_URL . '/public/assets/');
define('CLIMBING_CARD_ASSETS_URL', CLIMBING_CARD_URL . '/resources/assets/');
define('CLIMBING_CARD_VIEWS_PATH', CLIMBING_CARD_PATH . '/resources/views/');
define('CLIMBING_CARD_PREFIX', 'CLIMBING_CARD_');

// Initialize the plugin
(new ClimbingCard\Providers\Plugin)->init();

// Plugin activation and deactivation
register_activation_hook(__FILE__,   [\ClimbingCard\Providers\Activator::class,   'activate']);
register_deactivation_hook(__FILE__, [\ClimbingCard\Providers\Deactivator::class, 'deactivate']);
add_action('activated_plugin',       [\ClimbingCard\Providers\Activator::class,   'afterActivate']);
add_action('deactivated_plugin',     [\ClimbingCard\Providers\Deactivator::class, 'afterDeactivate']);
