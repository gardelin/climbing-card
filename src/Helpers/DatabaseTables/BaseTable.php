<?php

namespace ClimbingCard\Helpers\DatabaseTables;

abstract class BaseTable
{
    const TABLE_NAME = '';
    const TABLE_NAME_PREFIX = '';
    const SCHEMA_VERSION_OPTION_NAME = '';
    const SCHEMA_VERSION = '';

    /**
     * Returns table name.
     *
     * @return string
     */
    public static function getTableName()
    {
        return static::getTablePrefix() . static::TABLE_NAME;
    }

    /**
     * Return DB table prefix. Handles multisite tables.
     *
     * @return string
     */
    protected static function getTablePrefix()
    {
        global $wpdb;

        return $wpdb->get_blog_prefix() . static::TABLE_NAME_PREFIX;
    }

    /**
     * Check if table schema needs updating by comparing current version and
     * version from options table.
     *
     * @return bool
     */
    protected function schemaNeedsUpdating()
    {
        return version_compare(get_option(static::SCHEMA_VERSION_OPTION_NAME, '0'), static::SCHEMA_VERSION, '<');
    }

    /**
     * Save schema version as an entry in WP options table.
     *
     * @return bool
     */
    protected function saveSchemaVersion()
    {
        return update_option(static::SCHEMA_VERSION_OPTION_NAME, static::SCHEMA_VERSION);
    }

    /**
     * Return charset and collateion setting from global WPDB object.
     *
     * @return string
     */
    protected function getCharsetCollate()
    {
        global $wpdb;

        return $wpdb->get_charset_collate();
    }
}
