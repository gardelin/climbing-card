<?php

$namespace = 'ClimbingCard\Http\Api';

register_rest_route('climbingcard/v1', '/cards/(?P<user_id>\d+)',        ['methods' => 'GET',    'callback' => [$namespace . '\CardsController', 'getUserCards'],  'permission_callback' => '__return_true']);
register_rest_route('climbingcard/v1', '/cards/(?P<user_id>\d+)/delete', ['methods' => 'POST',   'callback' => [$namespace . '\CardsController', 'delete'],        'permission_callback' => 'ClimbingCard\can_access_card']);
register_rest_route('climbingcard/v1', '/cards/(?P<user_id>\d+)/update', ['methods' => 'POST',   'callback' => [$namespace . '\CardsController', 'update'],        'permission_callback' => 'ClimbingCard\can_access_card']);
register_rest_route('climbingcard/v1', '/cards/(?P<user_id>\d+)/export', ['methods' => 'GET',    'callback' => [$namespace . '\CardsController', 'export'],        'permission_callback' => 'ClimbingCard\can_access_card']);
register_rest_route('climbingcard/v1', '/cards',                         ['methods' => 'POST',   'callback' => [$namespace . '\CardsController', 'create'],        'permission_callback' => 'ClimbingCard\can_access_card']);
register_rest_route('climbingcard/v1', '/cards',                         ['methods' => 'GET',    'callback' => [$namespace . '\CardsController', 'all'],           'permission_callback' => 'ClimbingCard\is_administrator']);
register_rest_route('climbingcard/v1', '/users',                         ['methods' => 'GET',    'callback' => [$namespace . '\UsersController', 'index'],         'permission_callback' => '__return_true']);
register_rest_route('climbingcard/v1', '/users/me',                      ['methods' => 'GET',    'callback' => [$namespace . '\UsersController', 'me'],            'permission_callback' => 'ClimbingCard\can_access_card']);
register_rest_route('climbingcard/v1', '/stats/(?P<user_id>\d+)',        ['methods' => 'GET',    'callback' => [$namespace . '\StatsController', 'getUserStats'],  'permission_callback' => '__return_true']);
register_rest_route('climbingcard/v1', '/settings',                      ['methods' => 'GET',    'callback' => [$namespace . '\SettingsController', 'get'],        'permission_callback' => 'ClimbingCard\can_access_card']);
register_rest_route('climbingcard/v1', '/settings',                      ['methods' => 'POST',   'callback' => [$namespace . '\SettingsController', 'save'],       'permission_callback' => 'ClimbingCard\can_access_card']);
