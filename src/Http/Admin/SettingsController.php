<?php

namespace ClimbingCard\Http\Admin;

use function ClimbingCard\view;

class SettingsController 
{
    /**
     * Display the settings admin page
     * 
     * @return string
     */
    public static function index()
    {
        return view('admin/settings/index');
    }
}
