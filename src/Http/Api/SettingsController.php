<?php

namespace ClimbingCard\Http\Api;

use WP_REST_Request;

class SettingsController extends ApiController
{
    public static function get(WP_REST_Request $request)
    {
        $userId = $request->get_param('user_id');

        if (!$userId) {
            return ['message' => _e('Couldn\'t find user')];
        }

        $isClimbingCardPublic = get_user_meta($userId, 'is_climbing_card_public', true);

        // For users that don't have _is_climbing_card_public metadata force true
        $isClimbingCardPublic = $isClimbingCardPublic == '' ? 'true' : $isClimbingCardPublic;

        return [
            'is_climbing_card_public' => $isClimbingCardPublic,
        ];
    }

    /**
     * Save settings. 
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function save(WP_REST_Request $request)
    {
        $userId = $request->get_param('user_id');
        $isClimbingCardPublic = $request->get_param('is_climbing_card_public');

        $updated = update_user_meta($userId, 'is_climbing_card_public', $isClimbingCardPublic ? 'true' : 'false');

        return [
            'updated' => $updated,
            'is_climbing_card_public' => $isClimbingCardPublic,
        ];
    }
}
