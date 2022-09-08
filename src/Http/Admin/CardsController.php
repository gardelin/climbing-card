<?php

namespace ClimbingCard\Http\Admin;

use function ClimbingCard\view;

class CardsController 
{
    /**
     * Display the cards admin page
     * 
     * @return string
     */
    public static function index()
    {
        return view('admin/cards/index');
    }
}
