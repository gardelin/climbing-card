<?php

use ClimbingCard\Services\Route;

Route::setNamespace('ClimbingCard\Http');

Route::adminPage(
	__(
		'Climbing Card',
		'climbingcard'
	),
	'climbingcard',
	'Admin\CardsController@index',
	['position' => 40, 'capability' => 'read']
);
