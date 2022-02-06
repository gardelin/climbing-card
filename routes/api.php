<?php

$namespace = 'ClimbingCard\Http\Api';

register_rest_route('climbingcard/v1', '/cards/(?P<id>\d+)', ['methods' => 'GET', 'callback' => [$namespace . '\CardsController', 'getUserCards'],  'permission_callback' => '__return_true']);
