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
 * Clears permalink cache because of issues if a
 * funnel page has the same slug as another page
 *
 * @return void
 */
function clear_permalink_cache()
{
    flush_rewrite_rules(true);
}

/**
 * Convert a string to snake case.
 *
 * @param  string  $value
 * @param  string  $delimiter
 * @return string
 */
function snake_case($value, $delimiter = '_')
{
    if (!ctype_lower($value)) {
        $value = preg_replace('/\s+/u', '', ucwords($value));
        $value = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value), 'UTF-8');
    }

    return $value;
}

/**
 * Convert all array keys recursively to snake case
 *
 * @param  array $array
 * @return array
 */
function array_keys_to_snake_case(array $array): array
{
    foreach (array_keys($array) as $key) {
        $value = &$array[$key];
        unset($array[$key]);

        // Transform the key
        $transformedKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', ltrim($key, '!')));

        // Also handle recursive keys
        if (is_array($value)) {
            $value = array_keys_to_snake_case($value);
        }

        // Add the new key
        $array[$transformedKey] = $value;

        // And unset the value
        unset($value);
    }

    return $array;
}
