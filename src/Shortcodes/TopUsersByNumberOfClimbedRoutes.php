<?php

namespace ClimbingCard\Shortcodes;

use ClimbingCard\Repositories\Cards;
use function ClimbingCard\check_if_template_is_in_use;
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
        $pageId = check_if_template_is_in_use('cards/index.php');

        foreach ($users as $key => $user) {
            $userId = $user['user_id'] ;
            $user = get_userdata($userId);

            $url = $pageId !== null ? (get_page_link($pageId) . '#/users/' . $userId) : null;

            $fullname = trim($user->first_name . " " . $user->last_name);
            $users[$key]['fullname'] = $fullname;


            if ($url) 
                $users[$key]['card_url'] = $url;
        }

        return view('cards/top-users-by-number-of-climbed-routes', ['users' => $users], false);
    }
}
