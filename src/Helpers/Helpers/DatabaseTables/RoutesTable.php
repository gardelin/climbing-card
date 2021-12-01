<?php

namespace ClimbingCard\Helpers\DatabaseTables;

use ClimbingCard\Helpers\DatabaseTables\GradesTable;
use ClimbingCard\Helpers\DatabaseTables\SectorsTable;

class RoutesTable extends BaseTable implements CreatableDbTable
{
    const TABLE_NAME = 'routes';
    const SCHEMA_VERSION = '0.0';
    const SCHEMA_VERSION_OPTION_NAME = 'routes_schema_version';

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
                `name` varchar(255) NOT NULL DEFAULT '',
                `sector_id` bigint(10) unsigned NOT NULL,
                `grade_id` bigint(10) unsigned NOT NULL,
                `length` varchar(255) NOT NULL DEFAULT '',
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
                "ADD CONSTRAINT fk_grade_id FOREIGN KEY (grade_id) " .
                "REFERENCES " . (new GradesTable)->getTableName() . " (id)"
        );

        $query = $wpdb->query(
            "ALTER TABLE " . static::getTableName() . " " .
                "ADD CONSTRAINT fk_sector_id FOREIGN KEY (sector_id) " .
                "REFERENCES " . (new SectorsTable)->getTableName() . " (id) "
        );

        // Revert back error suppression status
        $wpdb->suppress_errors($didSuppressErrors);
    }
}
