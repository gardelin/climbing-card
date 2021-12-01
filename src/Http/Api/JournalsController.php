<?php

namespace ClimbingCard\Http\Api;

use ClimbingCard\Repositories\Journals;
use WP_REST_Request;

class JournalsController extends ApiController
{
    public static function getUserJournals(WP_REST_Request $request)
    {
        $userId = $request->get_param('id');

        if (!$userId) {
            // @TODO return error message
            return;
        }

        $user = get_userdata($userId);

        $journals = (new Journals)->getByUsername($user->user_login);

        return self::apiResponse(['journals' => $journals]);
    }
}
