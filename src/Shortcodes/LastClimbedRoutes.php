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
        $cards = Cards::getInstance()->all(['limit' => $number]);
        $data = [];

        foreach ($cards as $card) {
            $isClimbingCardPublic = get_user_meta($card->user_id, 'is_climbing_card_public', true) ?: 'true';

            if (!(bool) json_decode($isClimbingCardPublic)) {
                continue;
            }

            $user = get_userdata($card->user_id);
            $card->user_fullname = trim($user->first_name . " " . $user->last_name);

            array_push($data, $card);
        }

        return view('cards/last-climbed-routes', ['cards' => $data, 'options' => $attributes], false);
    }
}
