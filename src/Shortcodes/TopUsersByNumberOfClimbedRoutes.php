<?php

namespace ClimbingCard\Shortcodes;

use ClimbingCard\Repositories\Journals;
use function ClimbingCard\view;

class TopUsersByNumberOfClimbedRoutes
{
    /**
     * Calculate climbing card statistics and display it as list
     *
     * @param  array  $attributes
     * @param  null  $content
     * @param  string  $tag
     * 
     * @return string
     */
    public static function render($attributes = [], $content = null): string
    {
        $number = isset($attributes['number']) ? (int) $attributes['number'] : 10;

        $users = Journals::getInstance()->topUsersByNumberOfClimbedRoutes($number);

        foreach ($users as $key => $user) {
            $data = get_user_by('login', $user['username']);
            $fullname = $data->user_firstname . " " . $data->user_lastname;
            $users[$key]['fullname'] = $fullname;
        }

        return view('journal/top-users-by-number-of-climbed-routes', ['users' => $users], false);
    }
}
