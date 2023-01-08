<?php

namespace ClimbingCard\Repositories;

use ClimbingCard\Repositories\RepositoryAccess;
use ClimbingCard\Helpers\DatabaseTables\CardsTable;
use ClimbingCard\Model\Card;
use ClimbingCard\Services\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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


    /**
     * Get number of DB entries for specific user.
     * 
     * @return int
     */
    public function userCardsCount($user_id)
    {
        global $wpdb;

        $count = $wpdb->get_var("SELECT COUNT(*) FROM " . CardsTable::getTableName() . " WHERE user_id = " . esc_sql($user_id));

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
     * Get all crags.
     *
     * @param array $filters
     * @return Collection 
     */
    public function all(array $filters)
    {
        global $wpdb;

        $results = new Collection;
        $query = "SELECT * FROM " . CardsTable::getTableName() . " ORDER BY `climbed_at` DESC";

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
     * Get paginated cragd DB entries.
     *
     * @param array $filter
     * @param int $currentPage
     * @param int $perPage
     * @return LengthAwarePaginator 
     */
    public function getPaginatedFilteredData(array $filters, $currentPage = 1, $perPage = 10): LengthAwarePaginator
    {
        global $wpdb;

        $cardsTableName = CardsTable::getTableName();
        $usersTableName = $wpdb->prefix . 'users';
        $userMetaTableName = $wpdb->prefix . 'usermeta';

        $select = "SELECT `t`.*, `{$usersTableName}`.`user_email` AS email";
        $selectCount = "SELECT COUNT(`t`.`id`)";
        $from = "FROM `" . $cardsTableName . "` AS `t` ";
        $joins = ["INNER JOIN `{$usersTableName}` ON `t`.`user_id` = `{$usersTableName}`.`ID`"];
        $whereClauses = ["1 = 1"]; // Dummy clause to prevent issues when no filters are set

        // Filters
        $userId = $filters['userId'] ?? null;
        $publicCardboard = $filters['publicCardboard'] ?? null;
        $endDate = $filters['endDate'] ?? null;
        $startDate = $filters['startDate'] ?? null;
        $search = $filters['search'] ?? null;
        $orderBy = $filters['orderBy'] ?? 'id';

        // Filter by user_id
        if ($userId) {
            $whereClauses[] = sprintf("`t`.`user_id` = '%s'", esc_sql($userId));
        }

        // Filter by search (check crag, route, grade and style)
        if ($search) {
            $whereClauses[] = sprintf("(`t`.`crag` LIKE '%%%s%%' OR `t`.`route` LIKE '%%%s%%' OR `t`.`grade` = '%s')", esc_sql($search), esc_sql($search), esc_sql($search));
        }

        // Date filtering
        if ($startDate) {
            $whereClauses[] = sprintf("DATE_FORMAT(`t`.`created_at`, '%%Y-%%m-%%d') >= '%s'", esc_sql($startDate));
        }

        if ($endDate) {
            $whereClauses[] = sprintf("DATE_FORMAT(`t`.`created_at`, '%%Y-%%m-%%d') <= '%s'", esc_sql($endDate));
        }

        // Filter by is_climbing_card_public usermeta
        if ($publicCardboard) {
            $whereClauses[] = sprintf("NOT EXISTS (SELECT * FROM {$userMetaTableName} WHERE meta_key = 'is_climbing_card_public' AND `meta_value` != '%s' AND {$userMetaTableName}.user_id = {$usersTableName}.ID)", esc_sql($publicCardboard));
        }

        // Count query
        $query = $selectCount . " " .
            $from . " " .
            (count($joins) > 0 ? implode(" ", $joins) : "") . " " .
            "WHERE " . implode(" AND ", $whereClauses);

        $count = (int) $wpdb->get_var($query);

        // If there are no rows we don't need to run the second query
        if ($count === 0) {
            return new LengthAwarePaginator([], $count, $perPage, $currentPage, ['query' => $_GET]);
        }

        // Page offset
        $offset = ($currentPage - 1) * $perPage;

        // Data query
        $query = $select . " " .
            $from . " " .
            (count($joins) > 0 ? implode(" ", $joins) : "") . " " .
            "WHERE " . implode(" AND ", $whereClauses) . " " .
            "ORDER BY `t`.`{$orderBy}` DESC " .
            "LIMIT $offset, $perPage";

        $rows = $wpdb->get_results($query, ARRAY_A);

        $cardsData = [];
        if ($rows !== null) {
            // Hydrate stats data
            $cardsData = array_map(function ($row) {
                return new Card($row);
            }, $rows);
        }


        return new LengthAwarePaginator($cardsData, $count, $perPage, $currentPage, ['query' => $_GET]);
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
        $userMetaTableName = $wpdb->prefix . 'usermeta';
        $sql = "
        SELECT 
            COUNT(*) AS `total`, 
            `user_id` 
        FROM " . $tableName . "
        WHERE NOT EXISTS (SELECT * FROM wp_usermeta WHERE meta_key = 'is_climbing_card_public' AND `meta_value` != 'true' AND {$userMetaTableName}.user_id = {$tableName}.user_id)
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
