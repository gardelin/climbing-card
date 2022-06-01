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
            // @TODO return error message
            return;
        }
        sleep(1);

        $stats = Cards::getInstance()->userStats($userId);

        return self::apiResponse(['stats' => $stats]);
    }
}
