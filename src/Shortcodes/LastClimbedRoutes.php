<?php

namespace ClimbingCard\Shortcodes;

use ClimbingCard\Repositories\Cards;
use function ClimbingCard\view;

class LastClimbedRoutes
{
    /**
     * Render list of last n climbed routes
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
        $cards = Cards::getInstance()->getPaginatedFilteredData(['publicCardboard' => 'true', 'orderBy' => 'climbed_at'], 1, $number);
        $data = [];

        foreach ($cards->all() as $card) {
            $user = get_userdata($card->user_id);

            $card->user_fullname = $user->display_name;
            if ($user->first_name && $user->last_name) {
                $card->user_fullname = trim($user->first_name . " " . $user->last_name);
            }

            array_push($data, $card);
        }

        return view('cards/last-climbed-routes', ['cards' => $data, 'options' => $attributes], false);
    }
}
