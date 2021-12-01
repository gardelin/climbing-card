<?php

namespace ClimbingCard\Services;

use function ClimbingCard\Services\array_get;
use ClimbingCard\Services\Collection;

class Route
{
    /**
     * Admin pages collection
     * 
     * @var array
     */
    public static $adminPages = [];

    /**
     * Admin sub pages collection
     * 
     * @var array
     */
    public static $adminSubPages = [];

    /**
     * Admin pages without title collection
     * 
     * @var array
     */
    public static $adminSubPagesWithoutTitles = [];

    /**
     * Page controllers namespaces 
     *
     * @var string
     */
    protected static $namespace = 'ClimbingCard\Http';

    /**
     * Pages controllers namespace setter 
     *
     * @param  $namespace
     * @return void
     */
    public static function setNamespace($namespace)
    {
        self::$namespace = $namespace;
    }

    /**
     * Add wordpress admin page to collection
     *
     * @param string $label
     * @param string $route
     * @param mixed  $callback
     * @param array  $options
     * @return void
     */
    public static function adminPage($label, $route, $callback, $options = [])
    {
        static::$adminPages[] = [
            'route'      => $route,
            'label'      => $label,
            'title'      => array_get($options, 'title', $label),
            'icon'       => array_get($options, 'icon'),
            'position'   => array_get($options, 'position', 99),
            'capability' => array_get($options, 'capability', current_user_can('manage_options')),
            'callback'   => self::parseCallback($callback),
        ];
    }

    /**
     * Add wordpress sub admin page to collection
     *
     * @param string $label
     * @param string $parent
     * @param string $route
     * @param mixed  $callback
     * @param array  $options
     * @return void
     */
    public static function adminSubPage($label, $parent, $route, $callback, $options = [])
    {
        static::$adminSubPages[] = [
            'route'      => $route,
            'parent'     => $parent,
            'label'      => $label,
            'title'      => array_get($options, 'title', $label),
            'position'   => array_get($options, 'position', 999),
            'capability' => array_get($options, 'capability', current_user_can('manage_options')),
            'callback'   => self::parseCallback($callback),
            'options'    => $options,
        ];

        // If parent is not set then page won't have a <title>
        // Parent is usually not set for the page not to appear in the menu
        if (empty($parent)) {
            static::$adminSubPagesWithoutTitles[$route] = array_get($options, 'title', $label);
        }
    }

    /**
     * Register all admin pages and subpages
     * 
     * @return void
     */
    public static function registerAdminPages()
    {
        if (static::$adminPages) {
            $adminPages = new Collection(static::$adminPages);

            foreach ($adminPages as $adminPage) {
                add_menu_page(
                    $adminPage['label'],
                    $adminPage['title'],
                    $adminPage['capability'],
                    $adminPage['route'],
                    $adminPage['callback'],
                    $adminPage['icon'],
                    $adminPage['position']
                );
            }
        }

        if (static::$adminSubPages) {
            usort(static::$adminSubPages, function ($a, $b) {
                return $a['position'] > $b['position'];
            });

            foreach (static::$adminSubPages as $adminSubPage) {
                $route = array_get($adminSubPage, 'route');
                if ($route)
                    add_submenu_page(
                        $adminSubPage['parent'],
                        $adminSubPage['title'],
                        $adminSubPage['label'],
                        $adminSubPage['capability'],
                        $route,
                        $adminSubPage['callback'],
                    );

                $url = array_get($adminSubPage, 'options.url');
                if ($url)
                    add_submenu_page(
                        $adminSubPage['parent'],
                        $adminSubPage['title'],
                        $adminSubPage['label'],
                        $adminSubPage['capability'],
                        $url
                    );
            }
        }
    }

    /**
     * Setup a POST route
     *
     * @param string $route
     * @param mixed  $callback
     */
    public static function post($route, $callback)
    {
        $callback = self::parseCallback($callback);
        add_action('admin_action_' . $route, $callback);
    }

    /**
     * Parse a callback and return array with class/method combination
     *
     * @param  mixed $callback
     * @return array
     */
    public static function parseCallback($callback)
    {
        if (is_string($callback)) {
            $callbackParts = explode('@', $callback);
            $class         = self::$namespace . '\\' . $callbackParts[0];
            $method        = $callbackParts[1];
            $callback      = [$class, $method];
        }

        return $callback;
    }

    /**
     * Returns sub page title for given route. Uses $adminSubPagesWithoutTitles
     * for checking if sub page without a parent is registered.
     *
     * @param   string  $route
     *
     * @return  string
     */
    public static function getMissingSubPageTitle($route)
    {
        return isset(self::$adminSubPagesWithoutTitles[$route]) ? self::$adminSubPagesWithoutTitles[$route] : '';
    }
}
