<?php

namespace ClimbingCard\Repositories;

use ClimbingCard\Helpers\DatabaseTables\CardsTable;
use ClimbingCard\Repositories\RepositoryAccess;

class Users implements RepositoryAccess
{
    /**
     * @var Users
     */
    protected static $instance;

    /**
     * Check if user has climbing card
     * 
     * @return boolean
     */
    public function hasClimbingCard($id)
    {
        global $wpdb;

        $query = "SELECT * FROM " . CardsTable::getTableName() . " WHERE user_id = " . esc_sql($id) . " LIMIT 1";
        $results = $wpdb->get_results($query, ARRAY_A);

        if (empty($results)) {
            return false;
        }
;
        return true;
    }

    /**
     * Singleton
     *
     * @return User
     */
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
