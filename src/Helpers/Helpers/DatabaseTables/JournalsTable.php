<?php

namespace ClimbingCard\Helpers\DatabaseTables;

class JournalsTable extends BaseTable implements CreatableDbTable
{
    const TABLE_NAME = 'journals';
    const SCHEMA_VERSION = '0.0';
    const SCHEMA_VERSION_OPTION_NAME = 'journals_schema_version';

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
                `route_id` varchar(255) NOT NULL DEFAULT '',
                `style` varchar(255) NOT NULL DEFAULT '',
                `comment` varchar(255) DEFAULT '',
                `climbed_at` date NOT NULL,
                `created_at` datetime NOT NULL,
                `updated_at` datetime NOT NULL,
                `deleted_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) " . $this->getCharsetCollate() . ";";

            dbDelta($sql);

            $this->addForeignKeys();

            // Save schema version to options table to prevent this to run on every request
            $this->saveSchemaVersion();
        }
    }

    /**
     * Create foreign keys.
     *
     * @return void
     */
    protected function addForeignKeys()
    {
        global $wpdb;

        $didSuppressErrors = $wpdb->suppress_errors;

        // Prevent next query to show a warning
        $wpdb->suppress_errors(true);

        // In case that foreign key already exists it will throw an error to the log
        $wpdb->query(
            "ALTER TABLE " . static::getTableName() . " " .
                "ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) " .
                "REFERENCES " . $wpdb->users . " (ID) " .
                "ON DELETE CASCADE"
        );

        $query = $wpdb->query(
            "ALTER TABLE " . static::getTableName() . " " .
                "ADD CONSTRAINT fk_route_id FOREIGN KEY (route_id) " .
                "REFERENCES " . (new RoutesTable)->getTableName() . " (id) "
        );

        // Revert back error suppression status
        $wpdb->suppress_errors($didSuppressErrors);
    }
}
