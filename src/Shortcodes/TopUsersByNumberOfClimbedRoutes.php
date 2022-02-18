<?php

namespace ClimbingCard\Shortcodes;

use ClimbingCard\Repositories\Cards;
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

        $users = Cards::getInstance()->topUsersByNumberOfClimbedRoutes($number);

        foreach ($users as $key => $user) {
            $user = get_userdata($user['user_id']);
            $fullname = trim($user->first_name . " " . $user->last_name);
            $users[$key]['fullname'] = $fullname;
        }

        return view('cards/top-users-by-number-of-climbed-routes', ['users' => $users], false);
    }
}
