<?php

$namespace = 'ClimbingCard\Http\Api';

register_rest_route('climbingcard/v1', '/journals/(?P<id>\d+)', ['methods' => 'GET', 'callback' => [$namespace . '\JournalsController', 'getUserJournals'],  'permission_callback' => '__return_true']);
