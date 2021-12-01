<?php

namespace ClimbingCard\Http;

use OPDashboard\SL\SL;

class Controller
{
    /**
     * Abort HTTP request
     *
     * @param $code
     */
    public static function abort($code)
    {
        echo "Error: " . $code;
        die();
    }
}
