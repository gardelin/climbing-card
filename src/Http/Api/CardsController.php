<?php

namespace ClimbingCard\Http\Api;

use ClimbingCard\Repositories\Cards;
use WP_REST_Request;

class CardsController extends ApiController
{
    /**
     * Get all DB entries
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function all(WP_REST_Request $request)
    {
        $currentPage = (int)(isset($_GET['pg']) ? (intval($_GET['pg'])) : 1);
        $perPage = (int)(isset($_GET['per_pg']) ? (intval($_GET['per_pg'])) : 10);
        $startDate = (isset($_GET['start_date'])) ? sanitize_text_field($_GET['start_date']) : null;
        $endDate = (isset($_GET['end_date'])) ? sanitize_text_field($_GET['end_date']) : null;

        $cards = Cards::getInstance()->getPaginatedFilteredData(
            [
                'startDate' => $startDate,
                'endDate' => $endDate,
            ],
            $currentPage,
            $perPage
        );

        $cards->setPageName('pg');
        $cards->setPath(get_rest_url() . 'climbingcard/v1/cards');

        return self::apiResponse($cards);
    }

    /**
     * Get all user cards
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function getUserCards(WP_REST_Request $request)
    {

        $userId = $request->get_param('user_id');
        $currentPage = (int)(isset($_GET['pg']) ? (intval($_GET['pg'])) : 1);
        $perPage = (int)(isset($_GET['per_pg']) ? (intval($_GET['per_pg'])) : 10);
        $startDate = (isset($_GET['start_date'])) ? sanitize_text_field($_GET['start_date']) : null;
        $endDate = (isset($_GET['end_date'])) ? sanitize_text_field($_GET['end_date']) : null;

        $cards = Cards::getInstance()->getPaginatedFilteredData(
            [
                'userId' => $userId,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ],
            $currentPage,
            $perPage
        );

        $cards->setPageName('pg');
        $cards->setPath(get_rest_url() . 'climbingcard/v1/cards');

        return self::apiResponse($cards);
    }

    /**
     * Create DB entry.
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
