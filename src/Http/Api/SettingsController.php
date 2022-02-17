<?php

namespace ClimbingCard\Http\Api;

use ClimbingCard\Repositories\Cards;
use WP_REST_Request;

class SettingsController extends ApiController
{
    public static function get(WP_REST_Request $request)
    {
        $userId = $request->get_param('user_id');

        if (!$userId) {
            // @TODO return error message
            return;
        }

        $isClimbingCardPublic = get_user_meta($userId, 'is_climbing_card_public', true);

        return self::apiResponse([
            'is_climbing_card_public' => $isClimbingCardPublic == 'true' ? 'true' : 'false',
        ]);
    }

    /**
     * Save settings. 
     * user meta is_climbing_card_public 
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function save(WP_REST_Request $request)
    {
        $userId = $request->get_param('user_id');
        $isClimbingCardPublic = $request->get_param('is_climbing_card_public');

        $updated = update_user_meta($userId, 'is_climbing_card_public', $isClimbingCardPublic ? 'true' : 'false');

        return self::apiResponse([
            'updated' => $updated,
            'is_climbing_card_public' => $isClimbingCardPublic,
        ]);
    }
}
