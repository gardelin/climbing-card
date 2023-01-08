<?php

namespace ClimbingCard\Http\Api;

use ClimbingCard\Repositories\Cards;
use WP_REST_Request;

class CardsController extends ApiController
{
    /**
     * Get all DB entries
     * 
     * @TODO merge with getUserCards
     * If it's possible then api route is exposed to public, 
     * vuex admin/getCards is surplus
     * 
     * @return WP_REST_Response
     */
    public static function all()
    {
        $currentPage = (int)(isset($_GET['pg']) ? (intval($_GET['pg'])) : 1);
        $perPage = (int)(isset($_GET['per_pg']) ? (intval($_GET['per_pg'])) : 10);
        $startDate = (isset($_GET['start_date'])) ? sanitize_text_field($_GET['start_date']) : null;
        $endDate = (isset($_GET['end_date'])) ? sanitize_text_field($_GET['end_date']) : null;
        $search = (isset($_GET['search'])) ? sanitize_text_field($_GET['search']) : null;

        $paginatedCards = Cards::getInstance()->getPaginatedFilteredData(
            [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'search' => $search,
            ],
            $currentPage,
            $perPage
        );

        $paginatedCards->setPageName('pg');
        $paginatedCards->setPath(get_rest_url() . 'climbingcard/v1/cards');

        $response = $paginatedCards->toArray();
        $data = [];
        foreach ($response['data'] as $card) {
            $data[] = $card->toArray();
        }

        $response['data'] = $data;

        return $response;
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
        $search = (isset($_GET['search'])) ? sanitize_text_field($_GET['search']) : null;

        $paginatedCards = Cards::getInstance()->getPaginatedFilteredData(
            [
                'userId' => $userId,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'search' => $search,
            ],
            $currentPage,
            $perPage
        );

        $paginatedCards->setPageName('pg');
        $paginatedCards->setPath(get_rest_url() . 'climbingcard/v1/cards');

        $response = $paginatedCards->toArray();
        $data = [];
        foreach ($response['data'] as $card) {
            $data[] = $card->toArray();
        }

        $response['data'] = $data;

        return $response;
    }

    /**
     * Get all users climbed routes in order to export it to csv file.
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function export(WP_REST_Request $request)
    {
        $userId = $request->get_param('user_id');

        if (!$userId) {
            return self::apiErrorResponse(_e('Please provide user id!'));
        }

        $cards = Cards::getInstance()->getByUserId($userId);

        return ['cards' => $cards];
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

        return [
            'created' => true,
            'card' => $card->toArray(),
        ];
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

        return [
            'updated' => true,
            'card' => $card->toArray(),
        ];
    }

    /**
     * Delete DB entry.
     * 
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function delete(WP_REST_Request $request)
    {
        $id = $request->get_param('user_id');
        $deleted = Cards::getInstance()->delete($id);

        if (!$deleted)
            return [
                'message' => _e('Couldn\'t delete card')
            ];

        return  [
            'deleted' => true,
        ];
    }
}
