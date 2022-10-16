<?php

namespace ClimbingCard\Http\Api;

use ClimbingCard\Repositories\Cards;
use WP_REST_Request;

class StatsController extends ApiController
{
    public static function getUserStats(WP_REST_Request $request)
    {
        $userId = $request->get_param('user_id');

        if (!$userId) {
            return ['message' => _e('Couldn\'t find user')];
        }

        $stats = Cards::getInstance()->userStats($userId);

        return ['stats' => $stats];
    }
}
