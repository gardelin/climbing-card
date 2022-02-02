<?php

namespace ClimbingCard\Http\Api;

use ClimbingCard\Repositories\Cards;
use WP_REST_Request;

class CardsController extends ApiController
{
    public static function getUserCards(WP_REST_Request $request)
    {
        $userId = $request->get_param('id');

        if (!$userId) {
            // @TODO return error message
            return;
        }

        $user = get_userdata($userId);

        $crags = (new Cards)->getByUsername($user->user_login);

        return self::apiResponse(['crags' => $crags]);
    }
}
