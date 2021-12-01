<?php

namespace ClimbingCard\Helpers\DatabaseSeeders;

use ClimbingCard\Repositories\Crags;
use ClimbingCard\Repositories\Sectors;
use ClimbingCard\Repositories\Routes;
use ClimbingCard\Repositories\Grades;
use PHPHtmlParser\Dom;

class PlezanjeNetSeeder
{
    /**
     * Plezanje.net url
     */
    const PLEZANJE =  'https://www.plezanje.net/climbing/db/';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->crags = (new Crags);
        $this->sectors = (new Sectors);
        $this->grades = (new Grades);
        $this->routes = (new Routes);
    }

    /**
     * Fill database with plezanje.net data
     *
     * @return void
     */
    public function run()
    {
        // Fill old table only if new table is empty
        if ($this->crags->getCount() > 0)
            return;

        $url = self::PLEZANJE . 'cragIntro.asp?cc=HR&type=C&ord=n';
        $cragTableRows = $this->getTableRows($url, 2);

        $count = 0;
        foreach ($cragTableRows as $cragTableRow) {
            if ($count > 2)
                return;

            $crag = $this->createCrag($cragTableRow);

            if (!$crag)
                continue;

            $routeTableRows = $this->getTableRows($crag['url'], 6);
            $sectorId = null;

            $first = true;
            foreach ($routeTableRows as $key => $routeTableRow) {
                if ($first) {
                    $first = false;
                    continue;
                }

                $classAttribute = $routeTableRow->getAttribute('class');

                // Found sector
                if (strpos($classAttribute, 'sectorRow') !== false) {
                    $sectorId = $this->createSector($crag['id'], $routeTableRow);
                } else {
                    if (!$sectorId) {
                        $sectorId = $this->createSector($crag['id'], false);
                    }

                    $routeId = $this->createRoute($sectorId, $routeTableRow);
                }

                $i++;
            }

            $count++;
        }
    }

    /**
     * Get html crags page data and parse it
     *
     * @param string $url
     * @param int $url
     * @return DOMNodeList
     */
    public function getTableRows($url, $number = 0)
    {
        $html = new \DOMDocument;
        $html->loadHTMLFile($url);

        $tables = $html->getElementsByTagName('table');
        $table = $tables->item($number);
        $rows = $table->getElementsByTagName('tr');

        return $rows;
    }

    /**
     * Create crag
     *
     * @param DOMNodeList $data
     * @return array
     */
    public function createCrag($data)
    {
        $columns = $data->getElementsByTagName('td');

        if (!$columns->length)
            return null;

        $column = $columns->item(0);

        $crag = $this->crags->create([
            'title' => $column->textContent,
            'description' => $column->textContent,
        ]);

        $hrefAttribute = $column->getElementsByTagName('a')->item(0)->getAttribute('href');

        return [
            'id' => $crag->postId(),
            'url' => self::PLEZANJE . $hrefAttribute,
        ];
    }

    /**
     * Create sector
     *
     * @param int $cragId
     * @param DOMNodeList $data
     * @return int
     */
    public function createSector($cragId, $data)
    {
        $sectorName = "No Name";

        if ($data) {
            $columns = $data->getElementsByTagName('td');
            $sectorName = trim($columns->item(0)->textContent);
        }

        $sector = $this->sectors->create([
            'name' => $sectorName,
            'crag_id' => $cragId,
        ]);

        return $sector->id;
    }

    /**
     * Create route
     *
     * @param int $sectorId
     * @param DOMNodeList $data
     * @return int
     */
    public function createRoute($sectorId, $data)
    {
        $columns = $data->getElementsByTagName('td');
        $routeName = trim($columns->item(0)->textContent);
        $routeGrade = trim($columns->item(1)->textContent);
        $routeLength = trim($columns->item(2)->textContent);

        if ($routeGrade == 'P')
            $routeGrade = 'project';

        $grade = $this->grades->getByName($routeGrade);

        $route = $this->routes->create([
            'name' => $routeName,
            'sector_id' => $sectorId,
            'grade_id' => $grade->id,
            'length' => $routeLength,
        ]);

        return $route->id;
    }
}
