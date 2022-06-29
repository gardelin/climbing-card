<?php

namespace ClimbingCard\Repositories;

use ClimbingCard\Repositories\RepositoryAccess;
use ClimbingCard\Helpers\DatabaseTables\CardsTable;
use ClimbingCard\Model\Card;
use ClimbingCard\Services\Collection;

class Cards implements RepositoryAccess
{
    /**
     * @var Cards
     */
    protected static $instance;

    /**
     * Get all DB entries from old table
     * 
     * @return array
     */
    public function getRecordsFromOldTable()
    {
        global $wpdb;

        $query = "SELECT * FROM {$wpdb->prefix}ekarton_podaci";
        $results = $wpdb->get_results($query, ARRAY_A);

        return $results;
    }

    /**
     * Get number of DB entries in table.
     * 
     * @return int
     */
    public function count()
    {
        global $wpdb;

        $count = $wpdb->get_var("SELECT COUNT(*) FROM " . CardsTable::getTableName());

        return $count;
    }

    /*
    * Insert DB entry.
    * 
    * @param array $data
    * @return int|false
    */
    public function insert($data)
    {
        global $wpdb;

        $inserted = $wpdb->insert(CardsTable::getTableName(), $data);

        return $inserted;
    }

    /**
     * Create entry to DB table
     * 
     * @param array $data
     * @return Card|false
     */
    public function create($data): Card
    {
        global $wpdb;

        $only = Card::canBeUpdated();
        $data = array_filter($data, function ($v) use ($only) {
            return in_array($v, $only);
        }, ARRAY_FILTER_USE_KEY);

        $data['created_at'] = gmdate('Y-m-d H:i:s');
        $data['updated_at'] = gmdate('Y-m-d H:i:s');
        $data['user_id'] = get_current_user_id();

        $inserted = $wpdb->insert(CardsTable::getTableName(), $data);

        if (!$inserted)
            return false;

        $row = $wpdb->get_row("SELECT * FROM " . CardsTable::getTableName() . " WHERE id = " . $wpdb->insert_id, ARRAY_A);

        return new Card($row);
    }

    /**
     * Update DB entry.
     *
     * @param  array $data
     * @return Card|false
     */
    public function update(array $data): Card
    {
        global $wpdb;

        $only = Card::canBeUpdated();
        $dataToUpdate = array_filter($data, function ($v) use ($only) {
            return in_array($v, $only);
        }, ARRAY_FILTER_USE_KEY);

        $dataToUpdate['updated_at'] = gmdate('Y-m-d H:i:s');

        $updated = $wpdb->update(CardsTable::getTableName(), $dataToUpdate, ['id' => $data['id']]);

        if (false === $updated) {
            return false;
        }

        $row = $wpdb->get_row("SELECT * FROM " . CardsTable::getTableName() . " WHERE id = " . $data['id'], ARRAY_A);

        return new Card($row);
    }

    /**
     * Delete DB entries.
     *
     * @return bool
     */
    public function delete($id)
    {
        global $wpdb;

        // Delete the row
        $result = (bool) $wpdb->delete(CardsTable::getTableName(), ['id' => $id], ['%d']);

        return $result;
    }

    /**
     * Get all crags
     *
     * @return Collection
     */
    public function all($filters = []): Collection
    {
        global $wpdb;

        $results = new Collection;
        $query = "SELECT * FROM " . CardsTable::getTableName() . " ORDER BY `id` DESC";

        if (isset($filters['limit']))
            $query = $query . " LIMIT " . esc_sql($filters['limit']);

        $entries = $wpdb->get_results($query, ARRAY_A);

        foreach ($entries as $entry) {
            $Card = new Card($entry);
            $results->push($Card);
        }

        return $results;
    }

    /**
     * Get all user crags
     *
     * @param int $id user id
     * @return Collection
     */
    public function getByUserId($id)
    {
        global $wpdb;

        $results = new Collection;
        $tableName = CardsTable::getTableName();

        $entries = $wpdb->get_results("SELECT * FROM $tableName WHERE user_id =  '" . esc_sql($id) . "' ORDER BY climbed_at DESC", ARRAY_A);

        foreach ($entries as $entry) {
            $item = new Card($entry);
            $results->push($item);
        }

        return $results;
    }

    /**
     * Get stats data
     * 
     * @return array
     */
    public function stats()
    {
        global $wpdb;

        $tableName = CardsTable::getTableName();
        $sql = "
        SELECT
            COUNT(id) as total,
            SUM(CASE WHEN style = 'on sight' then 1 else 0 end) AS total_on_sight,
            SUM(CASE WHEN style = 'flash' then 1 else 0 end) AS total_flash,
            SUM(CASE WHEN style = 'red point' then 1 else 0 end) AS total_red_point,
            MAX(grade) as biggest_grade,
            (SELECT MAX(grade) FROM " . $tableName . " WHERE style = 'on sight') as biggest_on_sight,
            (SELECT MAX(grade) FROM " . $tableName . " WHERE style = 'red point') as biggest_red_point,
            (SELECT MAX(grade) FROM " . $tableName . " WHERE style = 'flash') as biggest_flash
        FROM " . $tableName;
        $result = $wpdb->get_row($sql, ARRAY_A);

        return $result;
    }

    /**
     * Get user stats data
     * 
     * @return array
     */
    public function userStats($id)
    {
        global $wpdb;

        $tableName = CardsTable::getTableName();
        $sql = "
        SELECT
            `grade`,
            COUNT(id) as total,
            SUM(CASE WHEN style = 'on sight' then 1 else 0 end) AS on_sight,
            SUM(CASE WHEN style = 'flash' then 1 else 0 end) AS flash,
            SUM(CASE WHEN style = 'red point' then 1 else 0 end) AS red_point
        FROM " . $tableName . "
        WHERE `user_id` = " . $id . "
        GROUP BY `grade`
        ORDER BY `grade` 
        DESC";

        $result = $wpdb->get_results($sql, ARRAY_A);

        return $result;
    }

    /**
     * Get top n users by number of climbed routes.
     * 
     * @param int $limit
     * 
     * @return array
     */
    public function topUsersByNumberOfClimbedRoutes($limit)
    {
        global $wpdb;

        $tableName = CardsTable::getTableName();
        $sql = "
        SELECT 
            COUNT(*) AS `total`, 
            `user_id` 
        FROM " . $tableName . " 
        GROUP BY `user_id` 
        ORDER BY `total` DESC LIMIT " . esc_sql($limit);
        $result = $wpdb->get_results($sql, ARRAY_A);

        return $result;
    }

    /**
     * Singleton
     *
     * @return Card
     */
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
