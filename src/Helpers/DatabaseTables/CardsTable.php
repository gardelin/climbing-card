<?php

namespace ClimbingCard\Helpers\DatabaseTables;

class CardsTable extends BaseTable implements CreatableDbTable
{
    const TABLE_NAME = 'climbing_cards';
    const SCHEMA_VERSION = '0.0';
    const SCHEMA_VERSION_OPTION_NAME = 'climbing_card_db_schema_version';

    /**
     * Creates and updates table using "dbdelta" and cached table version name.
     *
     * @return void
     */
    public function setup()
    {
        if ($this->schemaNeedsUpdating()) {
            // We need to "include" upgrade file to be able to use DB delta
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            $sql = "CREATE TABLE IF NOT EXISTS " . static::getTableName() . " (
                `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` bigint(10) unsigned NOT NULL,
                `route` varchar(255) NOT NULL DEFAULT '',
                `grade` varchar(255) NOT NULL DEFAULT '',
                `crag` varchar(255) NOT NULL DEFAULT '',
                `style` varchar(255) NOT NULL DEFAULT '',
                `comment` varchar(255) DEFAULT '',
                `climbed_at` date NOT NULL,
                `created_at` datetime NOT NULL,
                `updated_at` datetime NOT NULL,
                `deleted_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            );";

            dbDelta($sql);

            // $index = "ALTER TABLE `". static::getTableName() ."` ADD INDEX `wp_climbing_cards_id` (`id`)"

            // Save schema version to options table to prevent this to run on every request
            $this->saveSchemaVersion();
        }
    }
}
