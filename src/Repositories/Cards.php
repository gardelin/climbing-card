<?php

namespace ClimbingCard\Repositories;

use ClimbingCard\Helpers\DatabaseTables\CardsTable;
use ClimbingCard\Model\Card;
use ClimbingCard\Services\Collection;

class Cards
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
     * Add entry to DB table
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
     * Copied from old plugin (novikarton)
     */
    function ekarton_karton_exist($korisnik)
    {
        global $wpdb;
        $tableName = CardsTable::getTableName();
        $sql = "SELECT * FROM $tableName WHERE username = '" . esc_sql($korisnik) . "' LIMIT 1";
        $result = $wpdb->get_results($sql);

        if ($result)
            return 1;

        return 0;
    }

    /**
     * Copied from old plugin (novikarton)
     */
    function get_all_korisnik($korisnik)
    {
        global $wpdb;
        $tableName = CardsTable::getTableName();

        $sql = "SELECT * FROM $tableName WHERE username = '" . esc_sql($korisnik) . "' ORDER BY ocjena DESC";

        $rows = $wpdb->get_results($sql, ARRAY_A);

        echo '<table id="table_smjerovi" cellspacing="1" class="tablesorter">
                <thead>
                    <tr>
                        <th>Redni Broj</th>
                        <th>Smjer</th>
                        <th>Penjalište</th>
                        <th>Način</th>
                        <th>Ocjena</th>
                        <th>Komentar</th>
                        <th>Datum</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($rows as $key => $row) {
            echo '<tr class="pojedini_smjer">';
            echo '<td class="redni_broj">' . ($key + 1) . '</td>';
            echo '<td class="smjer">' . $row['smjer'] . '</td>';
            echo '<td class="penjaliste">' . $row['penjaliste'] . '</td>';
            echo '<td class="nacin"><span class="dot ' .  str_replace(" ", "-", $row['nacin']) . '" title="' . $row['nacin'] . '"></span></td>';
            echo '<td class="ocjena">' . $row['ocjena'] . '</td>';
            echo '<td class="komentar">' . $row['komentar'] . '</td>';
            echo '<td class="datum">' . $row['datum'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>
            </table>';
    }

    function racunaj_smjerove($korisnik, $nacin)
    {
        global $wpdb;
        $tableName = CardsTable::getTableName();
        $sql = "SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "'AND nacin='" . esc_sql($nacin) . "'";
        $rows = $wpdb->get_results($sql);

        echo count($rows);
    }

    /**
     * Copied from old plugin (novikarton)
     */
    function ukupno_smjerova($korisnik)
    {
        global $wpdb;
        $tableName = CardsTable::getTableName();
        $sql = "SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "'";
        $rows = $wpdb->get_results($sql, ARRAY_A);

        echo count($rows);
    }

    /**
     * Copied from old plugin (novikarton)
     */
    function najveca_ocjena($korisnik)
    {
        global $wpdb;
        $tableName = CardsTable::getTableName();
        $sql = "SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' ORDER BY ocjena DESC LIMIT 1";
        $row = $wpdb->get_results($sql, ARRAY_A);

        if (isset($row[0]))
            echo $row[0]['ocjena'];
    }

    /**
     * Copied from old plugin (novikarton)
     */
    function najveca_ocjena_nacin($korisnik, $nacin)
    {
        global $wpdb;
        $tableName = CardsTable::getTableName();
        $sql = "SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' AND nacin='" . $nacin . "' ORDER BY ocjena DESC LIMIT 1";
        $row = $wpdb->get_results($sql, ARRAY_A);

        if (isset($row[0]))
            echo $row[0]['ocjena'];
    }

    /**
     * Copied from old plugin (novikarton)
     */
    function po_ocjenama($korisnik)
    {
        global $wpdb;
        $tableName = CardsTable::getTableName();
        $sql = "SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' GROUP BY ocjena ORDER BY ocjena";
        $rows = $wpdb->get_results($sql, ARRAY_A);

        foreach ($rows as $row) {
            $ocjena = $row['ocjena'];
            $q_num = $wpdb->get_results("SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' AND ocjena='" . esc_sql($ocjena) . "'", ARRAY_A);
            $num_rows = count($q_num);

            $q_onsight = $wpdb->get_results("SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' AND ocjena='" . esc_sql($ocjena) . "' AND nacin='on sight'", ARRAY_A);
            $num_rows_on_sight = count($q_onsight);

            $q_flash = $wpdb->get_results("SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' AND ocjena='" . esc_sql($ocjena) . "' AND nacin='flash'", ARRAY_A);
            $num_rows_flash = count($q_flash);
            $num_rows_rp = $num_rows - $num_rows_on_sight - $num_rows_flash;

            echo '<tr><td><b>' . $ocjena . '</b></td><td>' . $num_rows . '</td><td>' . $num_rows_on_sight . '</td><td>' . $num_rows_flash . '</td><td>' . $num_rows_rp . '</td></tr>';
        }
    }

    /**
     * Copied from old plugin (novikarton)
     */
    function generiraj_graf($korisnik)
    {
        global $wpdb;
        $tableName = CardsTable::getTableName();
        $sql = "SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' GROUP BY ocjena ORDER BY ocjena";
        $rows = $wpdb->get_results($sql, ARRAY_A);

        foreach ($rows as $row) {
            $ocjena = $row['ocjena'];
            $q_num = $wpdb->get_results("SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' AND ocjena='" . esc_sql($ocjena) . "'", ARRAY_A);
            $num_rows = count($q_num);

            $q_onsight = $wpdb->get_results("SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' AND ocjena='" . esc_sql($ocjena) . "' AND nacin='on sight'", ARRAY_A);
            $num_rows_on_sight = count($q_onsight);

            $q_flash = $wpdb->get_results("SELECT * FROM $tableName WHERE userName='" . esc_sql($korisnik) . "' AND ocjena='" . esc_sql($ocjena) . "' AND nacin='flash'", ARRAY_A);
            $num_rows_flash = count($q_flash);
            $num_rows_rp = $num_rows - $num_rows_on_sight - $num_rows_flash;

            echo '[[' . $num_rows_on_sight . ', ' . $num_rows_flash . ', ' . $num_rows_rp . '], {label: "' . esc_sql($ocjena) . '"}],';
        }
    }

    /**
     * Singleton
     *
     * @return FileRepository
     */
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
