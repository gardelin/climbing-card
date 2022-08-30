<?php

namespace ClimbingCard\Http\Admin;

use ClimbingCard\Http\Controller;
use function ClimbingCard\view;

class CardsController extends Controller
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
