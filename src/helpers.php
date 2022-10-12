<?php

namespace ClimbingCard;

use League\Plates\Engine as ViewEngine;

/**
 * Simply load an admin CLIMBING_CARD_ view
 *
 * @param string $view
 * @param array $data
 * @param bool $output
 * @return void|string
 */
function view($view, $data = [], $output = true)
{
    $views = new ViewEngine(__DIR__ . '/../resources/views');

    if ($output === false) {
        return $views->render($view, $data);
    }

    echo $views->render($view, $data);
}

/**
 * Build up URL to plugin
 *
 * @param  string $path
 * @return string
 */
function plugin_url($path)
{
    return CLIMBING_CARD_URL . $path;
}

/**
 * Build up URL to plugin assets
 *
 * @param  string $path
 * @return string
 */
function assets_url($path)
{
    return plugin_url('public/assets/' . $path);
}

/**
 * Get path to plugin asset
 *
 * @param  string $path
 * @return string
 */
function asset($path = '')
{
    // Assets root
    $result = CLIMBING_CARD_ASSETS_URL;

    // Path
    if ($path) $result .= ltrim($path, '/');

    return $result;
}

/**
 * Get public path to plugin asset
 *
 * @param  string $path
 * @return string
 */
function asset_public_path($path = '')
{
    return CLIMBING_CARD_PUBLIC_ASSET_PATH . $path;
}

/**
 * Get path to plugin asset
 *
 * @param  string $path
 * @return string
 */
function asset_path($path = '')
{
    return CLIMBING_CARD_ASSET_PATH . $path;
}

/**
 * Get path to plugin views
 *
 * @param  string $path
 * @return string
 */
function views_path($path = '')
{
    return CLIMBING_CARD_VIEWS_PATH . $path;
}

/**
 * Check if we are currently on a op-protect admin page
 *
 * @return bool
 */
function is_admin_screen()
{
    $screen = get_current_screen();
    $allowed = [
        'climbingcard',
    ];

    foreach ($allowed as $page) {
        if (strpos($screen->id, $page) !== false)
            return true;
    }

    return false;
}

/**
 * Check if user have access to climbing cards.
 * 
 * @return bool
 */
function can_access_card()
{
    return (current_user_can('manage_options') || current_user_can('read'));
}

/**
 * Check if user administrator role 
 * 
 * @return bool
 */
function is_administrator()
{
    return current_user_can('administrator');
}

/**
 * Check if user is admin. 
 * 
 * @return bool
 */
function is_admin()
{
    return current_user_can('administrator');
}

/**
 * Check if specific page template is in use (at last one page that is using it)
 * 
 * @param string $template
 * @return null|int
 */
function check_if_template_is_in_use($template)
{
    $page_id = null;

    $pages = get_posts([
        'post_type'         => 'page',
        'posts_per_page'    => 1,
        'fields'            => 'ids',
        'meta_key'          => '_wp_page_template',
        'meta_value'        => $template
    ]);

    if ($pages) {
        $page_id = $pages[0];
    }

    return $page_id;
}
