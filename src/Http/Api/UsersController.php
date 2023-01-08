<?php

namespace ClimbingCard\Http\Api;

use ClimbingCard\Repositories\Users;
use ClimbingCard\Repositories\Cards;

class UsersController extends ApiController
{
    public static function index()
    {
        $users = get_users();
        $usersThatHavePublicClimbingCard = [];

        foreach ($users as $user) {
            $hasClimbingCard = Users::getInstance()->hasClimbingCard($user->ID);

            if (!$hasClimbingCard) {
                continue;
            }

            $isClimbingCardPublic = get_user_meta($user->ID, 'is_climbing_card_public', true);

            // User don't have meta key saved in database.
            // In this scenario we will assume that user's
            // climbing card is public
            if ($isClimbingCardPublic == '')
                $isClimbingCardPublic = 'true';

            $isClimbingCardPublic = filter_var($isClimbingCardPublic, FILTER_VALIDATE_BOOLEAN);

            if ($isClimbingCardPublic)
                array_push($usersThatHavePublicClimbingCard, [
                    'id' => $user->ID,
                    'firstname' => $user->user_firstname,
                    'lastname' => $user->user_lastname,
                    'display_name' => $user->data->display_name,
                    'cardsCount' => Cards::getInstance()->userCardsCount($user->ID),
                ]);
        }

        usort($usersThatHavePublicClimbingCard, function ($a, $b) {
            return strtolower($a['lastname']) > strtolower($b['lastname']);
        });

        return self::apiResponse(['users' => $usersThatHavePublicClimbingCard]);
    }

    /**
     * Return current user data
     * 
     * @return WP_REST_Response
     */
    public static function me()
    {
        $roles = [];

        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $roles = (array) $user->roles;
        }

        return ['roles' => $roles];
    }
}
