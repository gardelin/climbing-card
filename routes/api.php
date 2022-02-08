<?php

$namespace = 'ClimbingCard\Http\Api';

register_rest_route('climbingcard/v1', '/cards/(?P<user_id>\d+)', ['methods' => 'GET',  'callback' => [$namespace . '\CardsController', 'getUserCards'],  'permission_callback' => '__return_true']);
register_rest_route('climbingcard/v1', '/cards/(?P<id>\d+)',      ['methods' => 'PUT',  'callback' => [$namespace . '\CardsController', 'update'],        'permission_callback' => 'ClimbingCard\can_access_card']);
register_rest_route('climbingcard/v1', '/cards/(?P<id>\d+)',      ['methods' => 'POST', 'callback' => [$namespace . '\CardsController', 'insert'],        'permission_callback' => 'ClimbingCard\can_access_card']);
