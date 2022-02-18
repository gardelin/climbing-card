<?php

namespace ClimbingCard\Http\Api;

use ClimbingCard\Repositories\Cards;
use WP_REST_Request;

class CardsController extends ApiController
{
    public static function getUserCards(WP_REST_Request $request)
    {
        $userId = $request->get_param('user_id');

        if (!$userId) {
            // @TODO return error message
            return;
        }

        $cards = Cards::getInstance()->getByUserId($userId);

        return self::apiResponse(['cards' => $cards]);
    }

    /**
     * Update DB entry.
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function create(WP_REST_Request $request)
    {
        $data = $request->get_params();
        $card = Cards::getInstance()->create($data);

        if (!$card)
            return self::apiErrorResponse(_e('Couldn\'t create card'));

        return self::apiResponse([
            'created' => true,
            'card' => $card->toArray(),
        ]);
    }

    /**
     * Update DB entry.
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function update(WP_REST_Request $request)
    {
        $data = $request->get_params();
        $card = Cards::getInstance()->update($data);

        if (!$card)
            return self::apiErrorResponse(_e('Couldn\'t find card'));

        return self::apiResponse([
            'updated' => true,
            'card' => $card->toArray(),
        ]);
    }

    /**
     * Delete DB entry.
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function delete(WP_REST_Request $request)
    {
        $id = $request->get_param('id');
        $deleted = Cards::getInstance()->delete($id);

        if (!$deleted)
            return self::apiErrorResponse(_e('Couldn\'t delete card'));

        return self::apiResponse([
            'deleted' => true,
        ]);
    }
}
